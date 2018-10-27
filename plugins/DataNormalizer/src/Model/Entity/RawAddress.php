<?php
namespace DataNormalizer\Model\Entity;

use Cake\ORM\Entity;

/**
 * RawAddress Entity
 *
 * @property string $id
 * @property string $hash
 * @property string $path
 * @property float $lon
 * @property float $lat
 * @property string $number
 * @property string $street
 * @property string $unit
 * @property string $city
 * @property string $district
 * @property string $region
 * @property string $postcode
 */
class RawAddress extends Entity
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
        'id' => true,
        'path' => true,
        'lon' => true,
        'lat' => true,
        'number' => true,
        'street' => true,
        'unit' => true,
        'city' => true,
        'district' => true,
        'region' => true,
        'postcode' => true
    ];
}
