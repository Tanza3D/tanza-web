<?php
echo json_encode(Database::execSimpleSelect("SELECT * FROM Projects ORDER BY `Order` DESC"));