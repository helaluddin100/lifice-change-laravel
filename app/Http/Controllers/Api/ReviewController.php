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
           'email' => 'required|email:dns|unique:reviews,email,NULL,id,product_id,' . $request->product_id,
           'rating' => 'required|integer|min:1|max:5',
           'review' => 'nullable|string',
           'ip_address' => 'nullable|string', // Allow IP from Frontend
       ]);

       $ipAddress = $request->ip_address ?? $request->ip(); // Use Frontend IP or Fallback to Laravel IP

       // Check if user has already reviewed this product
       $existingReview = Review::where('product_id', $request->product_id)
           ->where('ip_address', $ipAddress)
           ->first();

       if ($existingReview) {
           return response()->json([
               'status' => 403,
               'message' => 'You have already reviewed this product.'
           ], 403);
       }

       // Store the Review
       $review = Review::create([
           'product_id' => $request->product_id,
           'shop_id' => $request->shop_id,
           'name' => $request->name,
           'email' => $request->email,
           'rating' => $request->rating,
           'review' => $request->review,
           'ip_address' => $ipAddress, // Ensure IP Address is stored
           'status' => 0 // Pending Approval
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
       $review->status = 1; // Approved
       $review->save();

       return response()->json([
           'status' => 200,
           'message' => 'Review approved successfully'
       ]);
   }

}