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

    'accepted' => ':attribute ক্ষেত্রটি অবশ্যই গ্রহণ করতে হবে।',
    'accepted_if' => ':other :value হলে :attribute ক্ষেত্রটি অবশ্যই গ্রহণ করা উচিত যখন ',
    'active_url' => ':attribute ক্ষেত্রটি অবশ্যই একটি বৈধ URL হতে হবে।',
    'after' => ':attribute ক্ষেত্রটি অবশ্যই :date এর পরে একটি তারিখ হতে হবে।',
    'after_or_equal' => ':attribute ক্ষেত্রটি অবশ্যই :date এর পরে বা তার সমান হতে হবে।',
    'alpha' => ':attribute ক্ষেত্রে শুধুমাত্র অক্ষর থাকতে হবে।',
    'alpha_dash' => ':attribute ক্ষেত্রে শুধুমাত্র অক্ষর, সংখ্যা, ড্যাশ এবং আন্ডারস্কোর থাকতে হবে।',
    'alpha_num' => ':attribute ক্ষেত্রে শুধুমাত্র অক্ষর এবং সংখ্যা থাকতে হবে।',
    'array' => ':attribute ক্ষেত্রটি অবশ্যই একটি অ্যারে হতে হবে।',
    'ascii' => ':attribute ফিল্ডে শুধুমাত্র একক-বাইট আলফানিউমেরিক অক্ষর এবং চিহ্ন থাকতে হবে।',
    'before' => ':attribute ক্ষেত্রটি অবশ্যই :date এর আগে একটি তারিখ হতে হবে।',
    'before_or_equal' => ':attribute ক্ষেত্রটি অবশ্যই :date এর আগে বা সমান একটি তারিখ হতে হবে।',
    'between' => [
        'array' => ':attribute ক্ষেত্রে অবশ্যই :min এবং :max আইটেমের মধ্যে থাকতে হবে।',
        'file' => ':attribute ক্ষেত্রটি অবশ্যই :min এবং :max কিলোবাইটের মধ্যে হতে হবে৷',
        'numeric' => ':attribute ক্ষেত্রটি অবশ্যই :min এবং :max এর মধ্যে হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি অবশ্যই :min এবং :max অক্ষরের মধ্যে হতে হবে।',
    ],
    'boolean' => ':attribute ক্ষেত্রটি সত্য বা মিথ্যা হতে হবে।',
    'can' => ':attribute ক্ষেত্রের একটি অননুমোদিত মান রয়েছে।',
    'confirmed' => ':attribute ক্ষেত্রের নিশ্চিতকরণ মেলে না।',
    'current_password' => 'পাসওয়ার্ডটি ভূল..',
    'date' => ':attribute ক্ষেত্রটি অবশ্যই একটি বৈধ তারিখ হতে হবে।',
    'date_equals' => 'ফিল্ড :attribute অবশ্যই :date তারিখের সাথে সমস্যামুক্ত হতে হবে।',
    'date_format' => 'ফিল্ড :attribute অবশ্যই :format স্বরূপে মিলতে হবে।',
    'decimal' => 'ফিল্ড :attribute অবশ্যই :decimal দশমিক স্থান থাকতে হবে।',
    'declined' => 'ফিল্ড :attribute অবশ্যই অস্বীকার্য হতে হবে।',
    'declined_if' => 'ফিল্ড :attribute অবশ্যই :other এর :value হওয়া প্রস্তুত থাকতে হবে না।',
    'different' => 'ফিল্ড :attribute ও :other অবশ্যই পৃথক হতে হবে।',
    'digits' => 'ফিল্ড :attribute অবশ্যই :digits সংখ্যা হতে হবে।',
    'digits_between' => 'ফিল্ড :attribute অবশ্যই :min থেকে :max সংখ্যা হতে হবে।',
    'dimensions' => 'ফিল্ড :attribute অবৈধ চিত্র মাত্রা থাকতে পারে।',
    'distinct' => 'ফিল্ড :attribute একই মান আছে।',
    'doesnt_end_with' => 'ফিল্ড :attribute অবশ্যই নিম্নলিখিত একটি দিয়ে শেষ হতে হবে: :values।',
    'doesnt_start_with' => 'ফিল্ড :attribute অবশ্যই নিম্নলিখিত একটি দিয়ে শুরু হতে হবে: :values।',
    'email' => 'ফিল্ড :attribute অবশ্যই একটি বৈধ ইমেইল ঠিকানা হতে হবে।',
    'ends_with' => ':attribute ক্ষেত্রটি অবশ্যই নিম্নলিখিতগুলির একটি দিয়ে শেষ হতে হবে: :values৷',
    'enum' => 'নির্বাচিত :attribute অবৈধ।',
    'exists' => 'নির্বাচিত :attribute অবৈধ।',
    'file' => ':attribute ক্ষেত্রটি অবশ্যই একটি ফাইল হতে হবে',
    'filled' => ':attribute ক্ষেত্রের একটি মান থাকতে হবে।',
    'gt' => [
        'array' => ':attribute ফিল্ডে অবশ্যই :value আইটেমের থেকে বেশি থাকতে হবে।',
        'file' => ':attribute ক্ষেত্রটি অবশ্যই :value কিলোবাইটের থেকে বেশি হতে হবে।',
        'numeric' => ':attribute ক্ষেত্রটি অবশ্যই :value-এর চেয়ে বড় হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি অবশ্যই :value অক্ষরের চেয়ে বড় হতে হবে।',
    ],
    'gte' => [
        'array' => ':attribute ফিল্ডে অবশ্যই :value আইটেম বা তার বেশি থাকতে হবে।',
        'file' => ':attribute ক্ষেত্রটি অবশ্যই :value কিলোবাইটের থেকে বড় বা সমান হতে হবে।',
        'numeric' => ':attribute ক্ষেত্রটি অবশ্যই :value এর থেকে বড় বা সমান হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি অবশ্যই :value অক্ষরের চেয়ে বড় বা সমান হতে হবে।',
    ],
    'image' => 'ক্ষেত্রটি একটি চিত্র হতে হবে।',
    'in' => 'নির্বাচিত :attribute অবৈধ।',
    'in_array' => ':attribute ক্ষেত্রটি :other অবস্থান করতে হবে।',
    'integer' => ':attribute ক্ষেত্রটি একটি পূর্ণসংখ্যা হতে হবে।',
    'ip' => ':attribute ক্ষেত্রটি একটি বৈধ আইপি ঠিকানা হতে হবে।',
    'ipv4' => ':attribute ক্ষেত্রটি একটি বৈধ আইপি ঠিকানা (IPv4) হতে হবে।',
    'ipv6' => ':attribute ক্ষেত্রটি একটি বৈধ আইপি ঠিকানা (IPv6) হতে হবে।',
    'json' => ':attribute ক্ষেত্রটি একটি বৈধ JSON স্ট্রিং হতে হবে।',
    'lowercase' => ':attribute ক্ষেত্রটি ছোট হাতের অক্ষরে হতে হবে।',
    'lt' => [
        'array' => ':attribute ক্ষেত্রটি অবশ্যই :value টির চেয়ে কম আইটেম হতে হবে।',
        'file' => ':attribute ক্ষেত্রটি অবশ্যই :value কিলোবাইটের চেয়ে কম হতে হবে।',
        'numeric' => ':attribute ক্ষেত্রটি অবশ্যই :value টির চেয়ে কম হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি অবশ্যই :value টির চেয়ে কম অক্ষর হতে হবে।',
    ],
    'lte' => [
        'array' => ':attribute ক্ষেত্রটি :value টির চেয়ে বেশি আইটেম থাকতে পারবে না।',
        'file' => ':attribute ক্ষেত্রটি :value কিলোবাইট বা তার কম হতে হবে।',
        'numeric' => ':attribute ক্ষেত্রটি :value বা তার কম হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি :value অক্ষর বা তার কম হতে হবে।',
    ],
    'mac_address' => ':attribute ক্ষেত্রটি সঠিক MAC ঠিকানা হতে হবে।',
    'max' => [
        'array' => ':attribute ক্ষেত্রটি :max টির চেয়ে বেশি আইটেম থাকতে পারবে না।',
        'file' => ':attribute ক্ষেত্রটি :max কিলোবাইটের চেয়ে বেশি হতে পারবে না।',
        'numeric' => ':attribute ক্ষেত্রটি :max টির চেয়ে বেশি হতে পারবে না।',
        'string' => ':attribute ক্ষেত্রটি :max অক্ষরের চেয়ে বেশি হতে পারবে না।',
    ],
    'max_digits' => ':attribute ক্ষেত্রটি :max টির চেয়ে বেশি ডিজিট থাকতে পারবে না।',
    'mimes' => ':attribute ক্ষেত্রটি ফাইলের ধরন :values হতে হবে।',
    'mimetypes' => ':attribute ক্ষেত্রটি ফাইলের ধরন :values হতে হবে।',
    'min' => [
        'array' => ':attribute ক্ষেত্রটি অবশ্যই অল্পতম :min টি আইটেম থাকতে হবে।',
        'file' => ':attribute ক্ষেত্রটি অবশ্যই অল্পতম :min কিলোবাইট হতে হবে।',
        'numeric' => ':attribute ক্ষেত্রটি অবশ্যই অল্পতম :min হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি অবশ্যই অল্পতম :min টি অক্ষর হতে হবে।',
    ],
    'min_digits' => ':attribute ক্ষেত্রটি অবশ্যই অল্পতম :min টি ডিজিট থাকতে হবে।',
    'missing' => ':attribute ক্ষেত্রটি অবশ্যই অনুপস্থিত হতে হবে।',
    'missing_if' => ':attribute ক্ষেত্রটি :other এ :value হলে অবশ্যই অনুপস্থিত হতে হবে।',
    'missing_unless' => ':attribute ক্ষেত্রটি :other এ :value না হলে অবশ্যই অনুপস্থিত হতে হবে।',
    'missing_with' => ':attribute ক্ষেত্রটি :values উপস্থিত থাকলে অবশ্যই অনুপস্থিত হতে হবে।',
    'missing_with_all' => ':attribute ক্ষেত্রটি :values সব উপস্থিত থাকলে অবশ্যই অনুপস্থিত হতে হবে।',
    'multiple_of' => ':attribute ক্ষেত্রটি :value এর একটি গুণিতক হতে হবে।',
    'not_in' => 'নির্বাচিত :attribute অবৈধ।',
    'not_regex' => ':attribute ক্ষেত্রের বিন্যাস অবৈধ।',
    'numeric' => ':attribute ক্ষেত্রটি অবশ্যই একটি সংখ্যা হতে হবে।',
    'password' => [
        'letters' => ':attribute ক্ষেত্রটি অবশ্যই কমপক্ষে একটি অক্ষর থাকতে হবে।',
        'mixed' => ':attribute ক্ষেত্রে অন্তত একটি বড় হাতের এবং একটি ছোট হাতের অক্ষর থাকতে হবে।',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => ':attribute ফিল্ডে অন্তত একটি সংখ্যা থাকতে হবে।',
        'uncompromised' => ':attribute ক্ষেত্রের মানটি ডেটা লিকে প্রদর্শিত হয়েছে। অনুগ্রহ করে একটি পৃথক :attribute চয়ন করুন।',
    ],
    'present' => 'ফিল্ডটি উপস্থিত থাকতে হবে।',
    'prohibited' => 'ফিল্ডটি নিষিদ্ধ।',
    'prohibited_if' => 'যদি :other মান :value হয়, তাহলে :attribute ক্ষেত্র নিষিদ্ধ।',
    'prohibited_unless' => 'যদি :other মান :values এর মধ্যে না থাকে, তাহলে :attribute ক্ষেত্র নিষিদ্ধ।',
    'prohibits' => ':attribute ক্ষেত্র :other ক্ষেত্রকে উপস্থিত থাকতে অনুমতি দেয় না।',
    'regex' => ':attribute ক্ষেত্রের ফর্ম্যাট অবৈধ।',
    'required' => ':attribute ক্ষেত্র প্রয়োজন।',
    'required_array_keys' => ':attribute ক্ষেত্রে নিম্নোক্ত প্রকারের আইটেমগুলি থাকতে হবে: :values।',
    'required_if' => ':other মান :value হয়, তাহলে :attribute ক্ষেত্র প্রয়োজন।',
    'required_if_accepted' => ':other ক্ষেত্র অনুমোদিত হলে :attribute ক্ষেত্র প্রয়োজন।',
    'required_unless' => ':other মান :values এর মধ্যে না থাকলে, :attribute ক্ষেত্র প্রয়োজন।',
    'required_with' => ':values উপস্থিত থাকলে :attribute ক্ষেত্র প্রয়োজন।',
    'required_with_all' => ':values উপস্থিত থাকলে :attribute ক্ষেত্র প্রয়োজন।',
    'required_without' => ':values অস্তিত্ব না থাকলে :attribute ক্ষেত্র প্রয়োজন।',
    'required_without_all' => ':values মধ্যে কোনটি উপস্থিত না থাকলে :attribute ক্ষেত্র প্রয়োজন।',
    'same' => ':attribute ক্ষেত্র সাথে মেলানো আবশ্যক: :other।',
    'size' => [
        'array' => ':attribute ক্ষেত্রে অবশ্যই :size আইটেম থাকতে হবে।',
        'file' => ':attribute ক্ষেত্রটি অবশ্যই :size কিলোবাইট হতে হবে।',
        'numeric' => ':attribute ক্ষেত্রটি অবশ্যই :size হতে হবে।',
        'string' => ':attribute ক্ষেত্রটি অবশ্যই :size অক্ষর হতে হবে।',
    ],
    'starts_with' => ':attribute ক্ষেত্রটি অবশ্যই নিম্নলিখিতগুলির একটি দিয়ে শুরু করতে হবে: :values৷',
    'string' => ':attribute ক্ষেত্রটি অবশ্যই একটি স্ট্রিং হতে হবে।',
    'timezone' => ':attribute ক্ষেত্রটি অবশ্যই একটি বৈধ টাইমজোন হতে হবে।',
    'unique' => ':attribute ইতিমধ্যে নেওয়া হয়েছে।',
    'uploaded' => ':attribute আপলোড করতে ব্যর্থ হয়েছে।',
    'uppercase' => ':attribute ক্ষেত্রটি অবশ্যই বড় হাতের হতে হবে।',
    'url' => ':attribute ক্ষেত্রটি অবশ্যই একটি বৈধ URL হতে হবে।',
    'ulid' => ':attribute ক্ষেত্রটি অবশ্যই একটি বৈধ ULID হতে হবে।',
    'uuid' => ':attribute ক্ষেত্রটি অবশ্যই একটি বৈধ UUID হতে হবে।',

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

    'attributes' => [],

];
