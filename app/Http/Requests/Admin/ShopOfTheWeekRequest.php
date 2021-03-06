<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Model\Admin\ShopOfTheWeek;
use Config;

class ShopOfTheWeekRequest extends Request
{
  /**
  * DateCreate 2016-01-25
  * Create By golf
  */
  private static $width ;
  private static $height ;
  /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    return true;
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules()
  {
    switch($this->method())
    {
      case 'GET':
      case 'DELETE':
      case 'POST':
      {
        self::setSize();
        return [
                'name'        => 'required|alpha_dash',
                'link_url'    => 'required|alpha_dash',
                'status'      => ['required','integer'],
                // 'imageupload' => 'required|image|image_size:'.self::$width.','.self::$height.'|mimes:'.Config::get('admin.upload.admin.mimes').'|max:'.Config::get('admin.upload.admin.storage'),
        ];
      }
      case 'PUT':
      case 'PATCH':
      {
        self::setSize();
        return [
                'name'        => 'required|alpha_dash',
                'link_url'    => 'required|alpha_dash',
                'status'      => ['required','integer'],
                // 'imageupload' => 'image|image_size:'.self::$width.','.self::$height.'|mimes:'.Config::get('admin.upload.admin.mimes').'|max:'.Config::get('admin.upload.admin.storage'),
        ];
      }
      default:break;
    }
  }

  /**
  * Change Language from user choose.
  *
  * @return array
  */
  public function messages()
  {
    if (in_array($this->session()->get('lang'), Config('admin.listTransLang')))
    {
      return [
        'name.required'           => trans('admin/text_message.nameShopOfTheWeek') . ' ' . trans('error.required'),
        'name.alpha_dash'         => trans('admin/text_message.nameShopOfTheWeek') . ' ' . trans('error.alpha_dash'),
        'link_url.required'       => trans('admin/text_message.link_url') . ' ' . trans('error.required'),
        'limit.alpha_dash'        => trans('admin/text_message.link_url') . ' ' . trans('error.alpha_dash'),
        'imageupload.required'    => trans('admin/text_message.imageupload') . ' ' . trans('error.required'),
        'imageupload.image'       => trans('error.image'),
        'imageupload.image_size'  => trans('admin/text_message.imageupload') . ' ' . trans('error.image_size',['width' => self::$width , 'height' => self::$height ]),
        'imageupload.mimes'       => trans('admin/text_message.imageupload') . ' ' . trans('error.mimes'),
        'imageupload.max'         => trans('admin/text_message.imageupload') . ' ' . trans('error.imageSizeMax'),
        'status.required'         => trans('admin/text_message.status') . ' ' . trans('error.required'),
        'status.integer'          => trans('admin/text_message.status') . ' ' . trans('error.integer'),
      ];
    }

    return [] ;
  }

  /**
  * Change Language from user choose.
  *
  */
  private static function setSize()
  {
    $dataSelect     = ShopOfTheWeek::getLocation()->first();
    self::$width    = $dataSelect->width;
    self::$height   = $dataSelect->height;
  }
}
