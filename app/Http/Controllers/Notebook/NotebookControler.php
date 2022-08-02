<?php

namespace App\Http\Controllers\Notebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Models\NotebookModel;

class NotebookControler extends Controller
{
    public function notebook() {
        return response()->json(NotebookModel::get(),200);
    }
}
