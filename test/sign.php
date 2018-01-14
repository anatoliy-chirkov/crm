<?php

$sign =
    hash(
        "sha256",
        "ntwc8o86aekb8dja2phoc1d1hpj215nf".$data."o9hnngkokvpjyyjreq5gi88qohifdvkr"
    )
;

echo $sign;