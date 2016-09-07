<?php
namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
	/**
	 * 根据指定的键对数组排序
	 *
	 * 用法：
	 * @code php
	 * $rows = array(
	 *     array('id' => 1, 'value' => '1-1', 'parent' => 1),
	 *     array('id' => 2, 'value' => '2-1', 'parent' => 1),
	 *     array('id' => 3, 'value' => '3-1', 'parent' => 1),
	 *     array('id' => 4, 'value' => '4-1', 'parent' => 2),
	 *     array('id' => 5, 'value' => '5-1', 'parent' => 2),
	 *     array('id' => 6, 'value' => '6-1', 'parent' => 3),
	 * );
	 *
	 * $rows = ArrayHelper::sortByCol($rows, 'id', SORT_DESC);
	 * dump($rows);
	 * // 输出结果为：
	 * // array(
	 * //   array('id' => 6, 'value' => '6-1', 'parent' => 3),
	 * //   array('id' => 5, 'value' => '5-1', 'parent' => 2),
	 * //   array('id' => 4, 'value' => '4-1', 'parent' => 2),
	 * //   array('id' => 3, 'value' => '3-1', 'parent' => 1),
	 * //   array('id' => 2, 'value' => '2-1', 'parent' => 1),
	 * //   array('id' => 1, 'value' => '1-1', 'parent' => 1),
	 * // )
	 * @endcode
	 *
	 * @param array $array 要排序的数组
	 * @param string $keyname 排序的键
	 * @param int $dir 排序方向
	 *
	 * @return array 排序后的数组
	 */
	public static function sortByCol($array, $keyname, $dir = SORT_ASC)
	{
		return self::sortByMultiCols($array, array($keyname => $dir));
	}
	
	/**
	 * 将一个二维数组按照多个列进行排序，类似 SQL 语句中的 ORDER BY
	 *
	 * 用法：
	 * @code php
	 * $rows = ArrayHelper::sortByMultiCols($rows, array(
	 *     'parent' => SORT_ASC,
	 *     'name' => SORT_DESC,
	 * ));
	 * @endcode
	 *
	 * @param array $rowset 要排序的数组
	 * @param array $args 排序的键
	 *
	 * @return array 排序后的数组
	 */
	public static function sortByMultiCols($rowset, $args)
	{
		$sortArray = array();
		$sortRule = '';
		foreach ($args as $sortField => $sortDir)
		{
			foreach ($rowset as $offset => $row)
			{
				$sortArray[$sortField][$offset] = $row[$sortField];
			}
			$sortRule .= '$sortArray[\'' . $sortField . '\'], ' . $sortDir . ', ';
		}
		if (empty($sortArray) || empty($sortRule)) { return $rowset; }
		eval('array_multisort(' . $sortRule . '$rowset);');
		return $rowset;
	}
	
	/**
	 * 判断Key在数组中是否存在
	 * 
	 * @param string $key
	 * @param array  $array
	 * @param bool   $return  是否返回改key对应的值
	 */
	public static function keyExists($key, $array, $return = false) {
	    
	    if(is_array($array) && array_key_exists($key, $array)) {
	        return $return ? $array[$key] : true;
	    }
	    else {
	        return $return ? '' : false;
	    }
	}

    /**
     * 二维数组按照指定字段进行排序
     * @param $arr
     * @param $keys
     * @param string $type
     * @return array
     */
    public static function arraySort($arr,$keys,$type='desc'){
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
    	
}