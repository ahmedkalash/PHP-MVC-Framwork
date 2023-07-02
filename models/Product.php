<?php
declare(strict_types=1);
namespace app\models;

use app\core\Model\Model;
use Illuminate\Container\Container;
use PDO;

class Product extends Model
{
    protected int $id;
    protected string $name;
    protected float $price;
    protected string $sku;

    protected static string $table_name = "products";


    public static function columns(): array
    {
        return ['id', 'name', 'price','sku'];
    }

    /**
     * @param string|null $orderBy
     * @return Product[]
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function all(string $orderBy=null): array
    {
        $orderBy = 'ORDER BY '.($orderBy?? static::primaryKeyName());
        $table = static::tableName();
        $selectQuery =  Container::getInstance()->make(\PDO::class)
            ->prepare("SELECT product.id , product.name , product.price, product.sku, attribute , value, unit
                    FROM $table as product
                    left join product_attributes_values pav on product.id = pav.product_id
                    $orderBy");
        $selectQuery->execute();
        $records = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

        return \app\core\Facade\Product::assemble($records);
    }

    /**
     * @param array $records
     * @return Product[]
     */
    public function assemble(array $records):array
    {
        $assembled = [];
        foreach ($records as& $record) {
            if(isset($assembled[$record['id']])) {
                $assembled[$record['id']]->attributes[$record['attribute']]=[
                    'value'=>$record['value'],
                    'unit'=>$record['unit']
                ];
            } else {
                $attributes=[];
                $attributes[$record['attribute']]=[
                    'value'=>$record['value'],
                    'unit'=>$record['unit']
                ];
                $product = Product::fromArray($record);
                $product->attributes =$attributes;
                $assembled[$product->id]=$product;
            }

            unset($record);
        }
        return array_values($assembled);
    }



}
