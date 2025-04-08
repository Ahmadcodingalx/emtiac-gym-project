<?php

namespace App\Interfaces;

interface ExportsInterface
{
    //
    public function exportBilanPdf($month);
    public function exportRestPayPdf($month);
}
