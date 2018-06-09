<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(StoreDocumentRequest $request, Movement $movement)
    {

    	$this->authorize('upload', $movement);

        $data = $request->validated();

        if($movement->document_id != null){
            $hasDocument = true;
            $currentDocument = Document::where('id', $movement->document_id)->firstOrFail();

            $extention = \File::extension($currentDocument->original_name);
            Storage::delete("documents/{$account->id}/{$movement->id}.{$extention}");
            $currentDocument->delete();
        }

        $extention = \File::extension($data['document_file']->getClientOriginalName());
        $file_name = $data['document_file']->getClientOriginalName();
        if($extention == "jpg"){
            $extention = "jpeg";
            $file_name = str_replace(".jpg", ".jpeg", $file_name);
        }

        $document_data = array(
            "created_at" => Carbon::now(),
            "description" => $data['document_description'],
            "original_name" => $file_name,
            "type" => $extention,
        );


        $newDocument = Document::create($document_data);

        $data['document_file']->storeAs("documents/{$account->id}", "{$movement->id}.{$extention}");

        $movement->document_id=$newDocument->id;
        $movement->save();

        return redirect()
            ->route('movement.edit', $movement->id)
            ->with('success', 'Document added successfully.');
    }

    
}
