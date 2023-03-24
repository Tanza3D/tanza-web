<?php
echo json_encode(Database::execSimpleSelect("SELECT * FROM Portfolio ORDER BY Date DESC"));