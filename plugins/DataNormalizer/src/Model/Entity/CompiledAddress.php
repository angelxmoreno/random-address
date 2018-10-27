<?php
namespace DataNormalizer\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompiledAddress Entity
 *
 * @property int $id
 * @property string $uuid
 * @property string $hash
 * @property float $lat
 * @property float $lng
 * @property string $number
 * @property string $street
 * @property string $unit
 * @property string $city
 * @property string $district
 * @property string $region
 * @property string $postcode
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modifed
 * @property string $path
 */
class CompiledAddress extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'uuid' => true,
        'hash' => true,
        'lat' => true,
        'lng' => true,
        'number' => true,
        'street' => true,
        'unit' => true,
        'city' => true,
        'district' => true,
        'region' => true,
        'postcode' => true,
        'created' => true,
        'modifed' => true,
        'path' => true
    ];
}
