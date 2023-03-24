<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => ' :attribute باید نتها شامل کاراکتر باشد.',
    'alpha_dash' => 'The :attribute تنها شامل کاراکتر, اعداد, خط تیره و خط باشد.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => ' :attribute باشد ارایه باشد.',
    'before' => ' :attribute باید قبل از  :date باشد.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => ' :attribute باید بین :min و :max عدد باشد.',
        'file' => ' :attribute باید بین :min و :max کیلوبایت باشد.',
        'string' => ' :attribute باید بین :min و :max کاراکتر باشد.',
        'array' => ' :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => ' :attribute و :other باید متفاوت باشد.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => ' :attribute باید بین :min و :max عدد باشد.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'فیلد :attribute می بایست یک ایمیل ادرس معتبر باشد.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => ' :attribute ارسال شده نامعتبر می باشد.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'فایل :attribute نباید بزرگتر از  :value کبلوبایت باشد.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => ' :attribute انتخاب شده نامعتبر می باشد',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'فیلد :attribute   بزرگتر از نباشد :max.',
        'file' => 'فیلد :attribute   بزرگتر از  :max کیلوبایت نباشد.',
        'string' => 'فیلد :attribute   بزرگتر از  :max کارااکتر نباشد.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'نوع :attribute باید از نوع: :values. باشد',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute باید حداقل :min باشد.',
        'file' => ' :attribute باید حداقل :min کیلو بایت باشد.',
        'string' => ' :attribute باید حداقل :min کاراکتر باشد.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ' :attribute باید عدد باشد.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'فیلد :attribute اجباری می باشد.',
    'required_if' => ' :attribute فیلد اجبار اسا وقتی فیلد :other داری  مقدار :value است.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'وقتی :attribute مقدار دارد فیلد  :values اجباری  می باشد.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => ' :attribute باید :size عدد باشد.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => ' :attribute باید :size کاراکتر باشد.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => ' :attribute باید با مقدار : :values شروع شود.',
    'string' => ' :attribute باید یک رشته باشد.',
    'timezone' => ' :attribute باید یک منطقه معتبر باشد.',
    'unique' => ' :attribute قبلا گرفته شده است.',
    'uploaded' => ' :attribute اپلود ناموفق می باشد.',
    'url' => ' :attribute فرمت نامعتبر می باشد.',
    'uuid' => ' :attribute must be a valid UUID.',
    'captcha' => ' :attribute اشتباه وارد شده است.',
    'phone' => 'شماره تلفن وارد شده معتبر نمی باشد .',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        "full_name"=>"نام و نام خانوادگی",
        "mobile"=>"موبایل",
        "national_code"=>"کد ملی",
        "user.full_name"=>"نام و نام خانوادگی",
        "user.mobile"=>"موبایل",
        "user.national_code"=>"کد ملی",
        "password"=>"رمز عبور",
        "national_code_mobile"=>"کد ملی یا موبایل",
        "pos.title"=>"عنوان دستگاه",
        "pos.code"=>"کد دستگاه",
        "pos.status"=>"وضعیت دستگاه",
        "profile_pack.code_sitak"=>"کد سیتاک پیک",
        "profile_customer.code_didar"=>"کد سپیدار مشتری",
        "profile_customer.email"=>"پست الکترونیک",
        "order.number_factor"=>"شماره فاکتور",
        "opinion.quality_food"=>"کیفیت غذا",
        "opinion.quality_service"=>"کیفیت سرویس",
        "opinion.cleaning"=>"نظافت",
        "opinion.behavior"=>"برخورد پرسنل",
        "orders_id"=>"سفارش",
        "time_login"=>"زمان ورود",
        "number"=>"تعداد",
        "menu.title"=>"عنوان",
        "menu.slug"=>"آدرس",
        "menu.status"=>"وضعیت",
        "category.title"=>"عنوان",
        "category.slug"=>"آدرس",
        "category.status"=>"وضعیت",
        "food.title"=>"عنوان غذا",
        "food.price"=>"مبلغ",
        "food.description"=>"توضیحات",
        "food.category_id"=>"دسته بندی",
        "menu_ids' =>"=>"منو ها",
        "menu_ids.*'"=>"منو",
        "food.status"=>"وضعیت",
    ],
];
