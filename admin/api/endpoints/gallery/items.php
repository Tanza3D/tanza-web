<?php
echo json_encode(Database::execSimpleSelect("SELECT * FROM Gallery ORDER BY Date DESC"));