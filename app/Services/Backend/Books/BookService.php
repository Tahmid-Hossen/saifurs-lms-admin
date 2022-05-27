<?php

namespace App\Services\Backend\Books;

use App\Http\Requests\Backend\Books\BookRequest;
use App\Models\Backend\Books\Book;
use App\Repositories\Backend\Books\BookRepository;
use App\Repositories\Backend\Books\InventoryHistoryRepository;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\Backend\Books\Inventory;
use Utility;

/**
 * Class BookService
 * @package App\Services\Backend\Book
 */
class BookService
{
    /**
     * @var BookRepository
     */
    private $bookRepository;
	
	
	private $inventoryRepository;

    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * BookService constructor.
     * @param BookRepository $bookRepository
     * @param FileUploadService $uploadService
     */
    public function __construct(BookRepository $bookRepository, InventoryHistoryRepository $inventoryRepository, FileUploadService $uploadService)
    {
        $this->bookRepository = $bookRepository;
		$this->inventoryRepository = $inventoryRepository;
        $this->fileUploadService = $uploadService;
    }

    /**
     * Get all Book
     *
     * @param array $filters
     *
     * @return Builder
     */
    public function getAllBook(array $filters): Builder
    {
        return $this->bookRepository->getBookWith($filters);
    }
	
	public function getBookInventory(array $filters): Builder
    {
        return $this->inventoryRepository->getInventory($filters);
    }
    /**
     * @param $input
     * @param string $prefix
     * @return string|null
     */
    public function uploadPreviewImage($input, string $prefix = 'book-thumbs-')
    {
        try {
            $data = [
                'image' => $input,
                'image_name' => $prefix . microtime(true),
                'destination' => \Utility::$imageUploadPath['book_preview_image'],
                'width' => \Utility::$bookImageSize['width'],
                'height' => \Utility::$bookImageSize['height']
            ];

            return $this->fileUploadService->savePhoto($data);

        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function uploadEbookFile($file)
    {
        try {
            $filename = $this->fileUploadService->saveFile($file, public_path(\Utility::$ebookUploadPath));
            return \Utility::$ebookUploadPath . $filename;
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function uploadPDFbookFile($file)
    {
        try {
            $filename = $this->fileUploadService->saveFile($file, public_path(\Utility::$pdfUploadPath));
            return \Utility::$pdfUploadPath . $filename;
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @param array $input
     * @param array $pivot
     * @return Book|false
     */
    public function storeBook(array $input, array $pivot)
    {
		//dd($input);
        try {
            $book = $this->bookRepository->create($input);
			
			$this->bookRepository->bookInventory($book);
			
            return $this->bookRepository->manageKeywords($book, $pivot);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @param $data
     * @param $keywords
     * @return Book|false
     */
    public function updateBook($id, $data, $keywords)
    {
        try {
            $book = $this->bookRepository->find($id);
            $this->bookRepository->update($data, $id);
			$checkbook = Inventory::where('book_id',$id)->first();
			if($checkbook==''){
				$this->bookRepository->bookInventory($book);
			}
			
            return $this->bookRepository->manageKeywords($book, $keywords);
        } catch (ModelNotFoundException $e) {
            \Log::error('Book not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }
	
	
	
	public function updateStocks($data)
    {		
		
        try {
            $book = $this->bookRepository->bookInventoryHistory($data);
			
            return true;
        } catch (ModelNotFoundException $e) {
            \Log::error('Book not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showBookByID($id)
    {
        return $this->bookRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteBook($id)
    {
        return $this->bookRepository->delete($id);
    }

    /**
     * @return array
     */
    public function getEbookTypeDropDown(): array
    {
        $ebookTypes = [];
        foreach ($this->bookRepository->getAllEbookTypes() as $type) {
            $ebookTypes[$type->ebook_type_id] = $type->ebook_type_name;
        }
        return $ebookTypes;
    }

    /**
     * @return string[]
     */
    public function getBookDropDown(): array
    {
        $books = [];
        foreach ($this->bookRepository->getBookWith([])->get() as $book) {
            $books[$book->book_id] = $book->book_name . ' - ' . $book->edition;
        }
        return $books;

    }


    /**
     * @param BookRequest $request
     * @return array
     * @throws Exception
     */
    public function getUploadedImage(BookRequest $request): array
    {
        $filePaths = [];
        for ($i = 0; $i <= 10; $i++) :
            if ($request->hasFile('photo.' . $i)) {
                $filePaths[$i] = $this->uploadPreviewImage($request->file('photo.' . $i));
            } else {
                if ($request->has('existing_image.' . $i)) {
                    $filePaths[$i] = $request->input('existing_image.' . $i);
                } else
                    $filePaths[$i] = null;
            }
        endfor;
        return $filePaths;
    }

    /**
     * @throws Exception
     */
    public
    function getUploadedFile(BookRequest $request)
    {
        if ($request->hasFile('ebook_file')) {
            return $this->uploadEbookFile($request->file('ebook_file'));
        } else if ($request->input('existing_file')) {
            return $request->input('existing_file');
        } else {
            return null;
        }
    }
    /**
     * @throws Exception
     */
    public function getUploadedPDFFile(BookRequest $request)
    {
        if ($request->hasFile('file')) {
            return $this->uploadPDFbookFile($request->file('file'));
        } else if ($request->input('previous_pdf')) {
            return $request->input('previous_pdf');
        } else {
            return null;
        }
    }

    /**
     * @param array $input
     * @param array $image_path
     * @param string|null $ebook_path
     * @return array
     */
    public
    function getRequestDataFormatted(array $input, array $image_path = [], string $ebook_path = null, string $file_path = null): array
    {
        return [
            'company_id' => $input['company'],
            'branch_id' => $input['branch'],
            'book_name' => $input['book_name'],
            'edition' => $input['edition'],
            'publisher' => $input['publisher'],
            'author' => $input['author'],
            'author_info' => $input['author_info'],
            'contributor' => $input['contributor'],
            'book_category_id' => $input['book_category'],
            'language' => $input['language'],
            'country' => $input['country'],
            'pages' => $input['page_number'] ?? 0,
            'book_status' => $input['status'] ?? 'ACTIVE',
            'is_ebook' => (isset($input['is_ebook']) && $input['is_ebook'] == 'YES') ? 'YES' : 'NO',
            'ebook_type_id' => (isset($input['is_ebook']) && $input['is_ebook'] == 'YES') ? $input['type'] : NULL,
            'is_sellable' => (isset($input['is_sellable']) && $input['is_sellable'] == 'YES') ? 'YES' : 'NO',
            'book_price' => (isset($input['is_sellable']) && $input['is_sellable'] == 'YES') ? floatval($input['book_price']) : NULL,
			'discount_price' => floatval($input['discount_price']) ?? NULL,
			'special_price' => floatval($input['special_price']) ?? NULL,
			'special_price_flag' => $input['special_price_flag'] ?? 0,
			'ragular_price_flag' => $input['ragular_price_flag'] ?? 0,
			'quantity' => $input['quantity'] ?? 1,
            'isbn_number' => $input['isbn_number'] ?? null,
            'publish_date' => $input['publish_date'],
            'book_description' => ($input['book_description']) ?? null,
            'currency' => 'BDT',
            'photo' => \Arr::flatten($image_path),
            'storage_path' => $ebook_path ?? null,
            'file' => $file_path ?? null,
        ];

    }

    public
    function assignTOUser(array $inputs): array
    {
        try {
            if (isset($inputs['book_id']) && isset($inputs['user_id'])) {
                $book_id = $inputs['book_id'];
                $book = $this->bookRepository->find($book_id);
                $book->users()->sync($inputs['user_id']);

                if ($book->save()) {
                    return ['status' => true, 'message' => 'Book assigned to user'];
                } else {
                    return ['status' => false, 'message' => 'Book assigned to user failed'];
                }
            }

            return ['status' => false, 'message' => 'Book or User information missing'];

        } catch (ModelNotFoundException | \Exception $exception) {
            \Log::error($exception->getMessage());
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

}
