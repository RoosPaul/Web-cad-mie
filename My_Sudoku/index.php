<?php
class Sudoku {

    private $_tab;
    
    public function __construct(array $tab = null) {
        $this->_tab = $tab;
    }
    
    public function algo() {
        $this->_tab = $this->solveSudoku($this->_tab);
        return $this->_tab;
    }
    
    public function displaySudoku() {
        include('header.php');
        echo '<div class="col-xs-4 col-xs-push-4">';
        echo '<h3>Réponse </h3>';

        echo '<table class="table table-condensed table-bordered" style="text-align:center;">';
        for ($row = 0; $row < 9; $row++) {
            echo '<tr>';
            for ($column = 0; $column < 9; $column++) {
                echo '<td>' . $this->_tab[$row][$column] . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
        include('footer.php');

    }
    
    private function solveSudoku($tab) {
        while(true) {
            $options = array();
            foreach ($tab as $rowIndex => $row) {
                foreach ($row as $columnIndex => $cell) {
                    if (!empty($cell)) {
                        continue;
                    }
                    $permissible = $this->getPermissible($tab, $rowIndex, $columnIndex);
                    if (count($permissible) == 0) {
                        return false;
                    }
                    $options[] = array(
                        'rowIndex' => $rowIndex,
                        'columnIndex' => $columnIndex,
                        'permissible' => $permissible
                        );
                }
            }
            if (count($options) == 0) {
                return $tab;
            }
            
            usort($options, array($this, 'sortOptions'));
            
            if (count($options[0]['permissible']) == 1) {
                $tab[$options[0]['rowIndex']][$options[0]['columnIndex']] = current($options[0]['permissible']);
                continue;
            }
            
            foreach ($options[0]['permissible'] as $value) {
                $tmp = $tab;
                $tmp[$options[0]['rowIndex']][$options[0]['columnIndex']] = $value;
                if ($result = $this->solveSudoku($tmp)) {
                    return $result;
                }
            }
            
            return false;
        }
    }
    
    private function getPermissible($tab, $rowIndex, $columnIndex) {
        $valid = range(1, 9);
        $invalid = $tab[$rowIndex];
        for ($i = 0; $i < 9; $i++) {
            $invalid[] = $tab[$i][$columnIndex];
        }
        $box_row = $rowIndex % 3 == 0 ? $rowIndex : $rowIndex - $rowIndex % 3;
        $box_col = $columnIndex % 3 == 0 ? $columnIndex : $columnIndex - $columnIndex % 3;
        $invalid = array_unique(array_merge(
            $invalid,
            array_slice($tab[$box_row], $box_col, 3),
            array_slice($tab[$box_row + 1], $box_col, 3),
            array_slice($tab[$box_row + 2], $box_col, 3)
            ));
        $valid = array_diff($valid, $invalid);
        shuffle($valid);
        return $valid;
    }
    
    private function sortOptions($a, $b) {
        $a = count($a['permissible']);
        $b = count($b['permissible']);
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
    
}
$grid = array(
    array(0, 0, 4, 0, 0, 6, 0, 0, 7),
    array(0, 0, 0, 1, 0, 0, 2, 0, 5),
    array(1, 0, 9, 5, 0, 7, 4, 0, 8),
    array(4, 0, 0, 0, 0, 0, 0, 2, 0),
    array(0, 0, 2, 0, 6, 0, 0, 9, 3),
    array(9, 0, 0, 2, 0, 3, 0, 0, 6),
    array(0, 8, 1, 0, 0, 0, 0, 5, 0),
    array(7, 0, 5, 3, 0, 2, 0, 0, 4),
    array(6, 0, 0, 9, 0, 0, 1, 0, 0),
    );

// $grid = array(
//     array(0,0,0,0,0,0,2,0,3),
//     array(8,0,7,0,0,0,0,6,0),
//     array(0,0,2,6,5,0,0,0,8),
//     array(0,3,0,0,0,0,0,0,0),
//     array(7,5,0,2,0,0,1,0,0),
//     array(0,0,1,0,3,0,5,0,0),
//     array(4,0,0,5,0,0,8,7,0),
//     array(6,0,0,0,4,2,0,0,0),
//     array(0,9,5,0,6,0,0,2,0)
//     );

$s = new Sudoku($grid);
$s->algo();
echo $s->displaySudoku();