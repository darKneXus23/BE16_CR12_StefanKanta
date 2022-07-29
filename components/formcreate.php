<?php
function formCreate($connect, $switch = "placeholder", $row = ["reduction" => 0]) {
    $columnquery = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='property';";
    $column = mysqli_query($connect,$columnquery);
    $data = mysqli_fetch_all($column);
    $formcreate = "";
    for ($i=0;$i<count($data);$i++) {
        if ($data[$i][0] == "image") {
            $formcreate .= "
                <div class='w-25 m-1'>
                    <label for='{$data[$i][0]}' class='form-label mb-1'>{$data[$i][0]}</label>
                    <input class='form-control' type='file' name='{$data[$i][0]}'/>
                </div>
            ";
        } else if ($data[$i][0] == "description") {
            $temp = $data[$i][0];
            $formcreate .= "
                <div class='w-100 m-1'>
                    <label for='{$data[$i][0]}' class='form-label mb-1'>{$data[$i][0]}</label>
                    <input class='form-control' type='text' name='{$data[$i][0]}' id='{$data[$i][0]}' {$switch}='" . ($switch == 'value'? $row[$temp] : $data[$i][0]) . "'>
                </div>
                ";
        } else if ($data[$i][0] == "reduction") {
            if ($row["reduction"] == 1) {
                $formcreate .= "
                                <div class='w-25 m-1'>
                                    <label for='{$data[$i][0]}' class='form-label mb-1'>{$data[$i][0]}</label>
                                    <select class='form-control' id='{$data[$i][0]}' name='{$data[$i][0]}'>
                                            <option value='0'>No</option>
                                            <option value='1' selected>Yes</option>
                                    </select>
                                </div>
                                ";
            } else {
                $formcreate .= "
                                <div class='w-25 m-1'>
                                    <label for='{$data[$i][0]}' class='form-label mb-1'>{$data[$i][0]}</label>
                                    <select class='form-control' id='{$data[$i][0]}' name='{$data[$i][0]}'>
                                            <option value='0'>No</option>
                                            <option value='1'>Yes</option>
                                    </select>
                                </div>
                                ";
            }
        } else if ($data[$i][0] == "id") {
            $formcreate .= "";
        } else {
            $temp = $data[$i][0];
            $formcreate .= "
                <div class='w-25 m-1'>
                    <label for='{$data[$i][0]}' class='form-label mb-1'>{$data[$i][0]}</label>
                    <input class='form-control py-1' type='text' name='{$data[$i][0]}' id='{$data[$i][0]}' {$switch}='" . ($switch == 'value'? $row[$temp] : $data[$i][0]) . "'>
                </div>
                ";
        };
    };
    return $formcreate;
}

?>