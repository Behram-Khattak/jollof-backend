<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\BusinessCategories;
use App\Enums\MediaCollectionNames;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Business;
use App\Models\BusinessBankAccount;
use App\Models\OnboardingFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessKycController extends Controller
{
    /**
     * Show the form to upload business kyc.
     *
     * @param Business $business
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Business $business)
    {
        $business->load('bankAccount.bank');

        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        $text = $onboard->kyc ? 'Submit' : 'Next';

        return view('merchant.business.kyc', [
            'banks'      => Bank::orderBy('name')->get(),
            'categories' => BusinessCategories::choices(),
            'business'   => $business,
            'kyc'        => $business->getMedia(MediaCollectionNames::KYC),
            'onboard'    => $onboard,
        ]);
    }

    /**
     * Upload new KYC document for the merchant.
     *
     * @param Business $business
     * @param Request  $request
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Business $business, Request $request)
    {

        $request->validate([
            'business_category' => ['required', 'string'],
            'bank_name'         => ['required', 'numeric', 'exists:banks,code'],
            'account_name'      => ['required', 'string'],
            'account_number'    => ['required', 'numeric'],
            //'cac_document.'      => ['present', 'array', 'max:5', 'mimes:JPEG,jpeg,bmp,jpg,JPG,png,pdf,PDF'],
            //'cac_document.*'      => ['present', 'max:5', 'mimes:JPEG,jpeg,bmp,jpg,JPG,png,pdf,PDF'],
        ]);

        BusinessBankAccount::updateOrCreate(
            [
                'business_id'    => $business->id,
            ],
            [
                'bank_id'        => Bank::whereCode($request->input('bank_name'))->first()->id,
                'account_name'   => $request->input('account_name'),
                'account_number' => $request->input('account_number'),
            ]
        );

        $business->clearMediaCollection(MediaCollectionNames::KYC);

        if (!empty($request->input('cac_document'))) {
            foreach ($request->input('cac_document') as $file) {
                $this->uploadImage($business, $file, MediaCollectionNames::KYC);
            }
        }

        $business->update([
            'category'    => $request->input('business_category'),
            'kyc_upload'  => true,
            'status'      => 'pending'
        ]);

        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        if ($onboard->kyc) {
            $path = route('merchant.business.kyc.create', $business);
        } else {
            $onboard->update(['kyc' => true]);

            $path = route('merchant.business.location.index', $business);
        }

        return response()->json(['data' => $path]);
    }

    /**
     * @param Business $business
     * @param          $file
     * @param string   $collection
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data
     */
    protected function uploadImage(Business $business, $file, string $collection)
    {
        $business->addMediaFromBase64($file)
            ->usingFileName($this->generateFileName($file))
            ->usingName(Str::random())
            ->toMediaCollection($collection);
    }

    protected function generateFileName($data)
    {
        @list($header, $base64string) = explode(',', $data);

        @list($prefix, $important) = explode(':', $header);

        @list($mimeType, $other) = explode(';', $important);

        return md5(Str::random() . microtime()) . '.' . $this->mimeToExtension($mimeType);
    }

    protected function mimeToExtension(string $mime)
    {
        // to take mime type as a parameter and return the equivalent extension
        $mimeList = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
    "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
    "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
    "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
    "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
    "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
    "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
    "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
    "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
    "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
    "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
    "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
    "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
    "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
    "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
    "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
    "pdf":["application\/pdf","application\/octet-stream"],
    "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
    "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
    "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
    "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
    "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
    "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
    "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
    "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
    "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
    "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
    "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
    "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
    "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
    "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
    "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
    "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
    "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
    "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
    "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
    "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
    "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
    "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
    "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
    "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
    "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
    "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
    "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
    "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';

        $mimeList = json_decode($mimeList, true);

        foreach ($mimeList as $key => $value) {
            if (array_search($mime, $value) !== false) {
                return $key;
            }
        }

        return false;
    }
}
