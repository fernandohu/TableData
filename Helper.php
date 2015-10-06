<?php
namespace fhu\TableData;

class Helper
{
    /**
     * @param array $data All rows must have the same length
     * @param array $indexArr
     * @return array
     */
    public static function pickColumnsByIndex(array $data, array $indexArr = [])
    {
        $result = [];

        if (count($data) == 0) {
            return $result;
        }

        foreach ($data as $row) {
            $resultRow = [];
            foreach ($indexArr as $index) {
                reset($row);
                for ($i = 0; $i < $index; $i++) next($row);

                $resultRow[] = current($row);
            }

            $result[] = $resultRow;
        }

        return $result;
    }

    /**
     * @param array $data All rows must have the same length
     * @param array $keyArr
     * @return array
     */
    public static function pickColumnsByKey(array $data, array $keyArr = [])
    {
        $result = [];

        if (count($data) == 0) {
            return $result;
        }

        foreach ($data as $row) {
            $resultRow = [];
            foreach ($keyArr as $key) {
                $resultRow[] = $row[$key];
            }

            $result[] = $resultRow;
        }

        return $result;
    }

    public static function addBefore(array $data, $valueToAdd)
    {
        $result = [];

        if (count($data) == 0) {
            return $result;
        }

        foreach ($data as $row) {
            $resultRow = [$valueToAdd];
            foreach ($row as $value) {
                $resultRow[] = $value;
            }

            $result[] = $resultRow;
        }

        return $result;
    }
}