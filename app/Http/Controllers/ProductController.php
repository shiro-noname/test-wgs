<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function all(Request $request){

        /* define record per page  */
        $per_page = (int) ($request->per_page ?? 15);

        /* limit per page not greater then 50 */
        if ($per_page > 50 ) {

            $per_page = 50;
        }

        return $this->core->setResponse('success', 'Get Products', Product::paginate($per_page));
    }

    public function showBySku(Request $request){

        $validator = $this->validation('find', $request);

        if ($validator->fails()) {

            return $this->core->setResponse('error', $validator->messages()->first(), NULL, false , 400  );
        }

        if (! $product = Product::where('Sku', '=', $request->Sku)->first()) {

            return $this->core->setResponse('error', 'Product Not Found', NULL, FALSE, 404);
        }

        return $this->core->setResponse('success', 'Product Found', $product);
    }

    public function store(Request $request) {

        /* validation requirement */
        $validator = $this->validation('create', $request);

        if ($validator->fails()) {
            return $this->core->setResponse('error', $validator->messages()->first(), NULL, false , 400  );
        }

        $input = $request->all();

        $user = Product::create($input);
        return $this->core->setResponse('success', 'Product created successfully!', $user );
    }

    public function update(Request $request) {

        /* validation requirement */
        $validator = $this->validation('update', $request);

        if ($validator->fails()) {

            return $this->core->setResponse('error', $validator->messages()->first(), NULL, false , 400  );
        }

        $product = Product::where('Sku', '=', $request->Sku)->first();

        $product->fill($request->only(['Product_name','Qty','Price','unit', 'Status']))->save();

        return $this->core->setResponse('success', 'Product Updated', $product);

    }

    public function delete(Request $request){

        $validator = $this->validation('delete', $request);

        if ($validator->fails()) {

            return $this->core->setResponse('error', $validator->messages()->first(), NULL, false , 400  );
        }

        if (! $product = Product::where('Sku', '=', $request->Sku)->first()) {

            return $this->core->setResponse('error', 'Product Not Found', NULL, FALSE, 404);
        }

        $product->delete();

        return $this->core->setResponse('success', 'Product deleted');

    }

    private function validation($type = null, $request) {

        switch ($type) {

            case 'create':

                $validator = [
                    'Sku' => 'required|unique:products,Sku',
                    'Product_name' => 'required',
                    'Qty' => 'required|numeric',
                    'Price' => 'required|numeric',
                    'unit' => 'required',
                    'Status' => 'required|in:0,1',
                ];

                break;

            case 'update':

                $validator = [
                    'Sku' => 'required',
                    'Product_name' => 'required',
                    'Qty' => 'required|numeric',
                    'Price' => 'required|numeric',
                    'unit' => 'required',
                    'Status' => 'required|in:0,1',
                ];

                break;

            case 'find' || 'delete':

                $validator = [
                    'Sku' => 'required',
                ];

                break;

            default:

                $validator = [
                    ''
                ];
        }

        return Validator::make($request->all(), $validator);
    }

}
