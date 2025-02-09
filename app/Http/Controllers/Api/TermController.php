<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Term;

class TermController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $term = Term::where('user_id', $userId)->get();

        return response()->json([
            'status' => 200,
            'term' => $term, // Fixing key
        ]);
    }

    public function getTermsByUser($id)
    {
        $term = Term::where('user_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'term' => $term, // <-- Fixing the key
        ]);
    }
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        $request->validate([
            'terms_con' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        $term = new Term();
        $term->terms_con = $request->terms_con;
        $term->user_id = $request->user_id;
        $term->shop_id = $request->shop_id;
        $term->status = $request->status;
        $term->save();

        return response()->json([
            'status' => 200,
            'message' => 'Terms and Conditions created successfully!',
            'term' => $term,
        ]);
    }



    public function edit($id)
    {
        $term = Term::find($id);

        if (!$term) {
            return response()->json(['message' => 'Terms and Conditions not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'term' => $term,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'terms_con' => 'nullable',
            'status' => 'required|boolean',
        ]);

        $term = Term::findOrFail($id);
        $term->terms_con = $request->terms_con;
        $term->status = $request->status;
        $term->save();

        return response()->json([
            'status' => 200,
            'message' => 'Terms and Conditions updated successfully!',
            'term' => $term, // Use "about" instead of "aboutUs"
        ]);
    }


    public function destroy($id)
    {
        $term = Term::find($id);

        if (!$term) {
            return response()->json(['message' => 'Terms and Conditions entry not found'], 404);
        }

        $term->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Terms and Conditions deleted successfully!',
        ]);
    }
}