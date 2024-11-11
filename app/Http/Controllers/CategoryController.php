<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return (new ApiResponseSuccessResource('List of Categories', $categories))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category = Category::create($request->only(['name']));

            return (new ApiResponseSuccessResource('Category Created Successfully', $category, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return (new ApiResponseSuccessResource('Category Details', $category))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Category Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
            ]);

            $category = Category::findOrFail($id);
            $category->update($request->only(['name']));

            return (new ApiResponseSuccessResource('Category Updated Successfully', $category))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return (new ApiResponseSuccessResource('Category Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Category Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
