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

    public function showAllReviews(Request $request, $id)
    {
        // Get search query (if any)
        $search = $request->query('search');

        // Fetch reviews with search functionality
        $query = Review::where('shop_id', $id)->with('replies', 'product');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('review', 'LIKE', "%{$search}%");
            });
        }

        // Apply pagination (10 reviews per page)
        $reviews = $query->orderBy('created_at', 'desc')->paginate(10);

        // Check if reviews exist
        if ($reviews->isEmpty()) {
            return response()->json(['error' => 'No reviews found'], 404);
        }


        return response()->json([
            'status' => 200,
            'data' => $reviews
        ]);
    }




    public function show($id)
    {

        $review = Review::with('replies')->find($id);

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        return response()->json([
            'status' => 200,
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
            'email' => 'required|email',
            'review' => 'required|string'
        ]);

        // ✅ Reply Create
        $reply = Review::create([
            'product_id' => $request->product_id,
            'shop_id' => $request->shop_id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'email' => $request->email,
            'review' => $request->review,
            'rating' => 0, // ✅ Replies don't have ratings
            'status' => 1, // ✅ Replies are auto-approved
            'ip_address' => request()->ip(), // ✅ Auto-detect IP
        ]);

        // ✅ Parent Review Status Update (Mark as Approved)
        $parentReview = Review::find($request->parent_id);
        if ($parentReview && $parentReview->status == 0) {
            $parentReview->update(['status' => 1]);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Reply added successfully & Parent review approved!',
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

    // Delete a Review (For Admin)
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Review deleted successfully'
        ]);
    }
}
