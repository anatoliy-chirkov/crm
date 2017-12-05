<?php

class FilesDAO
{
    public $path;
    public $userId;
    public $orderId;
    public $spreaderId;
    public $comment;

    public function parseSpreaderForm($form)
    {
        $this->spreaderId = $form['id'];
        $this->path = $form['path'];

        return $this;
    }
}
