<?php
declare(strict_types=1);
namespace app\core\QueryBuilder;

use app\core\Model\Model;
use Illuminate\Container\Container;
use PDO;

class QueryBuilder implements QueryBuilderInterface
{


    /**
     * @param PDO $db
     */
    public function __construct(
        public PDO $db,
    ) {
    }


    public function all(string $table, string $orderBy=null): array
    {
        $orderBy = $this->getOrderByClause($orderBy);
        $selectQuery =  $this->db->prepare("SELECT * FROM $table $orderBy");
        $selectQuery->execute();
        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }



    public function selectWhere(string $table, string $column, string $operator, float|bool|int|string|null $value, string $orderBy=null): array
    {
        $orderBy = $this->getOrderByClause($orderBy);
        $selectQuery =  $this->db->prepare("SELECT * FROM $table where $column $operator :value $orderBy");
        $selectQuery->bindValue('value', $value);
        $selectQuery->execute();
        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @param string $table
     * @param array<string, float|bool|int|string|null> $record associative array that represents the record to be inserted as $record[columnName]=value .
     * @return Model|false
     */
    public function insert(string $table, array $record, string $primaryKeyName='id')
    {
        $columns = array_keys($record);
        $columnsNamesSeparatedByComma = $this->getColumnsNamesSeparatedByComma($columns);
        $placeHolders = $this->getQueryNamedPlaceHolders($columns);
        $insertQuery = $this->db->prepare("INSERT INTO $table ($columnsNamesSeparatedByComma) values($placeHolders)");

        foreach ($columns as $column) {
            $insertQuery->bindValue($column, $record[$column]??null);
        }

        if(!$insertQuery->execute()){
            return false;
        }


        return $this->selectWhere($table, $primaryKeyName, '=', $this->db->lastInsertId())[0];

    }

    public function massDelete(string $table,array $ids,string $primaryKeyName='id'): bool
    {
        if(count($ids)<=0){
            return true;
        }
       $questionMarkPlaceHolders = $this->repeatQuestionMarkPlaceHolder(count($ids));
       $deleteQuery = $this->db->prepare("DELETE FROM $table WHERE $primaryKeyName IN ($questionMarkPlaceHolders)");

       foreach ($ids as $index=>$id){
           $deleteQuery->bindValue($index+1, $id);
       }

       return $deleteQuery->execute();
    }




    private function getColumnsNamesSeparatedByComma(array $columns)
    {
        $cols='';
        foreach ($columns as $column) {
            if($cols=='') {
                $cols .= $column;
            } else {
                $cols .= ",$column";
            }
        }
        return $cols;
    }
    private function getQueryNamedPlaceHolders(array $columns): string
    {
        $placeHolders='';
        foreach ($columns as $column) {
            $placeHolders .= (($placeHolders=='') ?  ":$column":",:$column");
        }
        return $placeHolders;
    }

    private function getOrderByClause(string $orderBy=null): string
    {
        return $orderBy? 'ORDER BY '.$orderBy  : '';
    }

    private function repeatQuestionMarkPlaceHolder(int $count)
    {
        $questionMarkPlaceHolders = '';
        for ($i = 1; $i<=$count ; $i++){
            if($i==1){
               $questionMarkPlaceHolders .= '?';
            }
            else {
                $questionMarkPlaceHolders .= ',?';
            }
        }
        return $questionMarkPlaceHolders;

    }


    public function unique(string|int|float|bool|null $value,string $table, string $column): bool
    {
        $selectQuery =  $this->db->prepare("SELECT COUNT(*) as count FROM $table WHERE $column = :value");
        $selectQuery->bindValue('value', $value);

        $selectQuery->execute();
        return $selectQuery->fetch(PDO::FETCH_ASSOC)['count']===0;

    }


    /**
     * @throws \Throwable
     */
    public function transaction(\Closure $callback):bool{
        if(!$this->db->beginTransaction()){
            return false;
        }
        try {
            Container::getInstance()->call($callback);

            return $this->db->commit();

        }catch (\Throwable $throwable){
            return false;
        }

    }

}
