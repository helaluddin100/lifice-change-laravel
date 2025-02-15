<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Review;


class ReviewController extends Controller
{
   // Fetch All Reviews for a Product (With Replies)
   public function getReviews($product_id)
   {
       $reviews = Review::where('product_id', $product_id)
           ->whereNull('parent_id') // Only main reviews
           ->where('status', 1) // Only approved reviews
           ->with(['replies'])
           ->get();

       return response()->json([
           'status' => 200,
           'data' => $reviews
       ]);
   }

   // Add Review (For Guest Users)
   public function addReview(Request $request)
   {
       $request->validate([
           'product_id' => 'required|exists:products,id',
           'shop_id' => 'required|exists:shops,id',
           'name' => 'required|string|max:100',
           'rating' => 'required|integer|min:1|max:5',
           'review' => 'nullable|string'
       ]);

       $review = Review::create([
           'product_id' => $request->product_id,
           'shop_id' => $request->shop_id,
           'name' => $request->name,
           'rating' => $request->rating,
           'review' => $request->review,
           'status' => 0 // Default status = pending
       ]);

       return response()->json([
           'status' => 201,
           'message' => 'Review submitted for approval.',
           'data' => $review
       ]);
   }

   // Reply to a Review
   public function replyReview(Request $request)
   {
       $request->validate([
           'product_id' => 'required|exists:products,id',
           'shop_id' => 'required|exists:shops,id',
           'parent_id' => 'required|exists:reviews,id',
           'name' => 'required|string|max:100',
           'review' => 'required|string'
       ]);

       $reply = Review::create([
           'product_id' => $request->product_id,
           'shop_id' => $request->shop_id,
           'parent_id' => $request->parent_id,
           'name' => $request->name,
           'review' => $request->review,
           'status' => 1 // Replies are automatically approved
       ]);

       return response()->json([
           'status' => 201,
           'message' => 'Reply added successfully',
           'data' => $reply
       ]);
   }

   // Approve a Review (For Admin)
   public function approveReview($review_id)
   {
       $review = Review::findOrFail($review_id);
       $review->status = 1;
       $review->save();

       return response()->json([
           'status' => 200,
           'message' => 'Review approved successfully'
       ]);
   }
}