<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParagraphRequest;
use App\Paragraph;
use Illuminate\Http\Request;

class ParagraphController extends Controller
{
    public function index() {
        $paragraphs = Paragraph::all();
        return view('welcome', [
            'paragraphs' => $paragraphs
        ]);
    }

    public function create() {
        return view('p.create');
    }

    public function store(ParagraphRequest $request) {
        $request->merge([
            'body' => preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', strip_tags($request->all()['body'], '<b><i><u><strike><ul><ol><li><br>'))
        ]);
        Paragraph::create($request->all());

        return redirect()->route('p.index');
    }

    public function edit($id) {
        $p = Paragraph::find($id);

        return view('p.edit', ['p' => $p]);
    }

    public function update(ParagraphRequest $request, $id) {
        $p = Paragraph::find($id);
        $p->fill($request->all());
        $p->save();

        return redirect()->route('p.index');
    }

    public function destroy($id) {
        Paragraph::find($id)->delete();

        return redirect()->route('p.index');
    }
}
