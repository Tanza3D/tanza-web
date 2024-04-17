<?php
if(isset($_GET['filter'])) {
    echo json_encode(Database::execSelect("SELECT * FROM Portfolio WHERE Tag = ? ORDER BY Date DESC", "i", [$_GET['filter']]));
} else {
    echo json_encode(Database::execSimpleSelect("SELECT * FROM Portfolio ORDER BY Date DESC"));
}   