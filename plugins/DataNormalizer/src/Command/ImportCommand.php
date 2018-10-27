<?php

namespace DataNormalizer\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Filesystem\Folder;
use DataNormalizer\Model\Table\BadAddressesTable;
use DataNormalizer\Model\Table\CompiledAddressesTable;
use DataNormalizer\Model\Table\RawAddressesTable;
use DataNormalizer\Plugin;
use League\Csv\Reader;
use League\Csv\ResultSet;
use League\Csv\Statement;
use UnexpectedValueException;

/**
 * Import command.
 *
 * @property BadAddressesTable $BadAddresses
 * @property CompiledAddressesTable $CompiledAddresses
 * @property RawAddressesTable $RawAddresses
 *
 * @property Folder $Folder
 * @property ConsoleIo $io
 */
class ImportCommand extends Command
{

    protected const REGEX_STATE = 'statewide\.csv';
    protected const REGEX_CSV = '.*\.csv';
    protected const LIMIT = 50;
    protected const ROOT_PATH = Plugin::DATA_DIR . 'us';
    protected const REGEX_PATH = Plugin::DATA_DIR . '(us/[^\.]*)\.csv';

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('BadAddresses');
        $this->loadModel('CompiledAddresses');
        $this->loadModel('RawAddresses');
        $this->Folder = new Folder(self::ROOT_PATH);
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int|mixed The exit code or null for success
     * @throws \League\Csv\Exception
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->setIo($io);
        $this->getIo()->out('Processing path:' . self::ROOT_PATH);
        $csv_files = $this->findFiles();
        $this->getIo()->out('Found ' . count($csv_files) . ' csv files');
        foreach ($csv_files as $csv_file) {
            $this->getIo()->out('Importing file:' . $csv_file);
            $this->importCsvFile($csv_file);
            $this->getIo()->out('Completed file:' . $csv_file);
            $this->renamePath($csv_file);

        }
    }

    protected function renamePath(string $csv_file)
    {
        $parts = pathinfo($csv_file);
        $new_path = sprintf('%s/%s.%s',
            $parts['dirname'],
            $parts['filename'],
            'completed'
        );
        rename($csv_file, $new_path);
    }

    protected function findFiles() : array
    {
//        return ['/var/www/html/data/us/ak/yakutat_borough.csv'];

        $csv_files = [];
        $states = $this->Folder->subdirectories();
        foreach ($states as $state) {
            $this->Folder->cd($state);

            $state_file = $this->Folder->find(self::REGEX_STATE);
            $state_file_exists = count($state_file) > 0;

            $files = ($state_file_exists)
                ? $state_file
                : $this->Folder->find(self::REGEX_CSV);

            foreach ($files as $file) {
                $csv_files[] = $state . DS . $file;
            }
        }

        return $csv_files;
    }

    /**
     * @param string $path
     * @throws \League\Csv\Exception
     */
    protected function importCsvFile(string $path)
    {
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $this->getIo()->out('Processing ' . number_format($csv->count()) . ' records');
        $this->processRecords($csv, $path);
    }

    /**
     * @param Reader $csv
     * @param string $path
     * @throws \League\Csv\Exception
     * @throws \Exception
     */
    protected function processRecords(Reader $csv, string $path)
    {
        $total_pages = $this->totalPages($csv);
        $this->getIo()->out('Iterating ' . number_format($total_pages) . ' pages');

        for ($page = 1; $page <= $total_pages; $page++) {
            $records = $this->getPagedRecords($csv, $page);
            $this->getIo()->out($path . ' Importing page ' . number_format($page) . ' of ' . number_format($total_pages));
            $this->importRecords($records, $path);
        }
    }

    protected function totalPages(Reader $csv) : int
    {
        return ceil($csv->count() / self::LIMIT);
    }

    /**
     * @param Reader $csv
     * @param int $page
     * @return ResultSet
     * @throws \League\Csv\Exception
     */
    protected function getPagedRecords(Reader $csv, int $page) : ResultSet
    {
        $offset = ($page - 1) * self::LIMIT;
        $stmt = (new Statement())
            ->offset($offset)
            ->limit(self::LIMIT);
        $headers = array_flip(array_change_key_case(array_flip($csv->getHeader()), CASE_LOWER));

        return $stmt->process($csv, $headers);
    }

    /**
     * @param ResultSet $records
     * @param string $path
     * @throws \Exception
     */
    protected function importRecords(ResultSet $records, string $path)
    {
        $pattern = '~' . self::REGEX_PATH . '~';
        preg_match($pattern, $path, $matches);

        if (count($matches) < 2) {
            throw new UnexpectedValueException(
                'Could not get path name:' .
                json_encode(compact('pattern', 'path', 'matches'))
            );
        }

        $name = $matches[1];

        $entities = [];
        foreach ($records as $record) {
            $record['path'] = $name;

            foreach ($record as $key => $val) {
                if (trim($val) === '') {
                    unset($record[$key]);
                }
            }
            $found = $this->RawAddresses
                ->find()
                ->where([
                    'hash' => $record['hash']
                ])->first();

            if ($found) {
//                $this->getIo()->out('Found raw address ' . $record['hash']);
                $address = $this->RawAddresses->patchEntity($found, $record);
            } else {
//                $this->getIo()->out('Creating raw address ' . $record['hash']);
                $address = $this->RawAddresses->newEntity($record);
            }

            if ($errors = $address->getErrors()) {
                $this->getIo()->out('Found bad raw address ' . print_r($errors, true));

                $bad_address = $this->BadAddresses->newEntity([
                    'path' => $name,
                    'errors' => $errors,
                    'data' => $record,
                ]);

                $this->BadAddresses->saveOrFail($bad_address);
            } else {
                $entities[] = $address;
            }
        }
        $this->getIo()->out(
            'Saving  ' .
            number_format(count($entities)) .
            ' raw addresses'
        );

        if ($entities) {
            $saved = $this->RawAddresses->saveMany($entities);
            if (!$saved) {
                $this->getIo()->error('Unable to save raw addresses');
            }
        }
    }

    /**
     * @return ConsoleIo
     */
    public function getIo() : ConsoleIo
    {
        return $this->io;
    }

    /**
     * @param ConsoleIo $io
     */
    public function setIo(ConsoleIo $io) : void
    {
        $this->io = $io;
    }
}
