<?php

ini_set('xdebug.max_nesting_level', 10000);

//class Solution {
//    private array $s;
//    private array $t;
//
//    private int $sLength;
//    private int $tLength;
//
//    private int $sLast;
//    private int $tLast;
//
//    public function numDistinct(string $s, string $t): int {
//        $this->s = str_split($s);
//        $this->t = str_split($t);
//
//        $this->sLength = count($this->s);
//        $this->tLength = count($this->t);
//
//        $this->sLast = $this->sLength - 1;
//        $this->tLast = $this->tLength - 1;
//
//        return $this->numDistinctRecursion();
//    }
//
//    private function numDistinctRecursion(int $i = 0, int $j = 0): int {
//        if ($i == $this->sLength) {
//            return 0;
//        }
//
//        if ($j == $this->tLength) {
//            return 0;
//        }
//
//        if ($this->s[$i] == $this->t[$j]) {
//            if ($j == $this->tLast) {
//                return 1 + $this->numDistinctRecursion($i + 1, $j);
//            }
//
////            if ($i == $this->sLast) {
////                return 0;
////            }
//
//            return
//                $this->numDistinctRecursion($i + 1, $j) +
//                $this->numDistinctRecursion($i + 1, $j + 1);
//        }
//
//        return $this->numDistinctRecursion($i + 1, $j);
//    }
//}

class Solution {

    /**
     * @param String $s
     * @param String $t
     * @return Integer
     */
    function numDistinct($s, $t) {
        $this->t = $t;
        $this->memo = [];
        return $this->countSubsequences($s, 0);
    }

    function countSubsequences($subs, $idx) {
        if (substr($subs, 0, $idx) === $this->t) {
            return 1;
        }
        if (strlen($subs) < strlen($this->t) || $idx >= strlen($subs) || $idx >= strlen($this->t)) {
            return 0;
        }
        if (isset($this->memo[$subs][$idx])) {
            return $this->memo[$subs][$idx];
        }
        if ($subs[$idx] === $this->t[$idx]) {
            $this->memo[$subs][$idx] = $this->countSubsequences($subs, $idx + 1) + $this->countSubsequences(substr($subs, 0, $idx) . substr($subs, $idx + 1), $idx);
            return $this->memo[$subs][$idx];
        }
        $this->memo[$subs][$idx] = $this->countSubsequences(substr($subs, 0, $idx) . substr($subs, $idx + 1), $idx);
        return $this->memo[$subs][$idx];
    }
}

echo (new Solution())->numDistinct(str_repeat('agshdfghjkhhlweghriiootyuiioioo', 10), str_repeat('aghio', 5));





