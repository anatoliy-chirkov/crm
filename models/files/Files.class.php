<?php

class Files
{
    public function getSpreaderFile($form)
    {
        $data = (new FilesDAO)->parseSpreaderForm($form);

        $sql = "select path from files where spreader_id = '$data->spreaderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function addSpreaderFile($form)
    {
        $data = (new FilesDAO)->parseSpreaderForm($form);

        $sql = "insert into files (path) values ('$data->path') where spreader_id = '$data->spreaderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function insertFile()
    {
        if ($_FILES["file"]["size"] > 1024 * 10 * 1024) {
            echo("Размер файла превышает 10 мегабайт");
            return false;
        }

        $path = 'userfiles/';
        $ext = array_pop(explode('.', $_FILES['file']['name']));
        $fileName = time() . '.' . $ext;
        $filePath = $path . $fileName;

        if ($_FILES['file']['error'] == 0) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                //$_POST['path'] = $fileName;
                print_r($_POST); die();
                return $_POST;
            }
        }
    }
}
