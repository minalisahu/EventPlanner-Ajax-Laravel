<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Enquery;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Product;
use App\Models\Testimonail;
use App\Models\User;
use App\Notifications\ProductEnquiry;
use App\Notifications\SendEnequery;
use App\Notifications\SendEnquiryToCustomer;
use Validator;

class SupportController extends BaseController
{
    public function pages()
    {
        $pages = Page::get();
        return $this->sendResponse($pages, 'List of all product categories.');

    }

    public function testimonials()
    {
        $testimonials = Testimonail::with('image')->active()->get();
        return $this->sendResponse($testimonials, 'List of all testimonials.');

    }

    public function faqs()
    {
        $faqs = Faq::active()->get();
        return $this->sendResponse($faqs, 'List of all faqs.');

    }

    public function contactus(Request $request)
    {
        $data =$request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:3|max:15',
            'subject' => 'required',
            'message' => 'required',

        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if ($enquiry = Enquery::create($data)) {
            $users = User::active()->where('access', 1)->get();
            foreach ($users as $user) {
                $user->notify(new SendEnequery($data));
            }
            $enquiry->notify(new SendEnquiryToCustomer());
            return $this->sendResponse($enquiry, 'Thank you for contacting us, we have sent an acknowledgement of query received to your email. We will shortly contact you');
        }
        return $this->apiSomethingWentWorng('Unexpected error occurred while trying to process your request.');
    }


    public function productEnquiryStore(Request $request, $productId)
    {

        $product = Product::find($productId);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        
        $data =$request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:3|max:15',
            'subject' => 'required',
            'message' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $data['type'] = 'product';
        if ($enquiry = Enquery::create($data)) {
            $enquiry->notify(new ProductEnquiry($data, $productId));
            return $this->sendResponse($enquiry, 'Thank you for contacting us, we have sent an acknowledgement of query received to your email. We will shortly contact you');
        }
        return $this->apiSomethingWentWorng('Unexpected error occurred while trying to process your request.');
    }
}
