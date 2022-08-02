<?php

namespace App\Http\Controllers;

use http\Env\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Models\NotebookModel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Matcher\Not;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $id_global = 0;

    public function notebook() {
        return response()->json(NotebookModel::paginate(5),200);
    }

    public function notebookById($id) {
        $notebook = NotebookModel::find($id);
        if (is_null($notebook)) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        } else {
            return response()->json($notebook,200);
        }
    }
    public function notebookNew(\Illuminate\Http\Request $req) {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'id' => 'required|integer|unique:App\Models\Models\NotebookModel',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        };
        $notebook = NotebookModel::create($req->all());
        if (is_null($notebook->photo)) {
            return response()->json($notebook, 201);
        } else {
            $file = $req->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = $notebook->photo . '.' . $extension;
            $req->file('photo')->store('', 'public');
            return response()->json($notebook, 201);
        };
    }

    public function notebookNewById(\Illuminate\Http\Request $req, $id) {
        $notebook_exist = NotebookModel::find($id);
        if (is_null($notebook_exist)) {
            $rules = [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };
            $data['id'] = $id;
            $req->merge($data);
            $notebook = NotebookModel::create($req->all());
            if (is_null($notebook->photo)) {
                return response()->json($notebook, 201);
            } else {
                $file = $req->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = $notebook->photo . '.' . $extension;
                $req->file('photo')->store('', 'public');
                return response()->json($notebook, 201);
            };
        } else {
            return response()->json(['error' => true, 'message' => 'Already posted'], 423);
        }

    }

    public function notebookDelete($id) {
        $notebook = NotebookModel::find($id);
        if (is_null($notebook)) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        } else {
            $notebook->delete();
            return response()->json('Deleted', 204);
        }
    }

    public function notebookEdit(\Illuminate\Http\Request $req, $id) {
        $rules = [
            'name' => Rule::notIn([null]),
            'phone' => Rule::notIn([null]),
            'email' => Rule::notIn([null]),
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        };
        $notebook = NotebookModel::find($id);
        if (is_null($notebook)) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        } else {
            $notebook->update($req->all());
            return response()->json($notebook, 200);
        }
    }
}
