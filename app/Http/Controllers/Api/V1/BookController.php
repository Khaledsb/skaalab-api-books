<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\BookRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\BookDestroyRequest;
use App\Http\Requests\Api\V1\BookIndexRequest;
use App\Http\Requests\Api\V1\BookShowRequest;
use App\Http\Requests\Api\V1\BookStoreRequest;
use App\Http\Requests\Api\V1\BookUpdataRequest;
use App\Http\Resources\Api\V1\BookResource;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BookIndexRequest $request)
    {
        try {
            $books = $this->bookRepository->findAll();

            return response()->json([
                'books' => BookResource::collection($books),
                'code' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $book = $this->bookRepository->store($data);

            return response()->json([
                'message' => 'Book created successfully',
                'books' => new BookResource($book),
                'code' => Response::HTTP_CREATED
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookShowRequest $request)
    {
        $data = $request->validated();

        try {
            $book = $this->bookRepository->get($data['book']);

            return response()->json([
                'books' => new BookResource($book),
                'code' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdataRequest $request)
    {
        $data = $request->validated();

        try {
            $this->bookRepository->update($data, $data['book']);
            
            return response()->json([
                'books' => 'Book updated successfully',
                'code' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookDestroyRequest $request)
    {

        $data = $request->validated();

        try {
            $this->bookRepository->delete($data['book']);

            return response()->json([
                'books' => 'Book Delete successfully',
                'code' => Response::HTTP_NO_CONTENT
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_NOT_FOUND
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}
