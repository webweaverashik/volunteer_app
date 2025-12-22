<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Do I need prior experience to become a volunteer?',
                'question_bn' => 'স্বেচ্ছাসেবক হতে কি কোনো পূর্ব অভিজ্ঞতা প্রয়োজন?',
                'answer' => 'No, prior experience is not required. We will provide necessary training and guidance to all volunteers.',
                'answer_bn' => '<strong class="text-green-600">না,</strong> কোনো পূর্ব অভিজ্ঞতার প্রয়োজন নেই। আমরা সব স্বেচ্ছাসেবকদের প্রয়োজনীয় প্রশিক্ষণ ও নির্দেশনা প্রদান করব। আপনার আগ্রহ এবং সময় দেওয়ার ইচ্ছাই যথেষ্ট।',
                'color' => 'green',
                'order' => 1,
            ],
            [
                'question' => 'How much time do I need to give daily?',
                'question_bn' => 'প্রতিদিন কত সময় দিতে হবে?',
                'answer' => 'This is completely up to you. You can give 1-4 hours daily, 5-10 hours weekly, or just on weekends.',
                'answer_bn' => 'এটি সম্পূর্ণভাবে <strong class="text-blue-600">আপনার ওপর নির্ভর করে।</strong> আপনি দৈনিক ১-৪ ঘণ্টা, সাপ্তাহিক ৫-১০ ঘণ্টা, অথবা শুধু শুক্র-শনিবার সময় দিতে পারেন।',
                'color' => 'blue',
                'order' => 2,
            ],
            [
                'question' => 'What kind of work will I do?',
                'question_bn' => 'কি ধরনের কাজ করতে হবে?',
                'answer' => 'Based on your interest and skills, you can work on campaigns, media & content, events, election day support, research, and social/cultural activities.',
                'answer_bn' => 'আপনার আগ্রহ ও দক্ষতা অনুযায়ী বিভিন্ন ধরনের কাজ করতে পারবেন - <strong class="text-purple-600">প্রচারণা, মিডিয়া ও কনটেন্ট, জনসভা আয়োজন, নির্বাচন দিবসে সহায়তা, রিসার্চ, সামাজিক ও সাংস্কৃতিক কার্যক্রম।</strong>',
                'color' => 'purple',
                'order' => 3,
            ],
            [
                'question' => 'Can I be a volunteer if I am not a resident of Sylhet-3?',
                'question_bn' => 'আমি কি সিলেট-৩ এর বাসিন্দা না হলেও স্বেচ্ছাসেবক হতে পারব?',
                'answer' => 'Yes, absolutely! Anyone can volunteer for our campaign. Many tasks can be done online.',
                'answer_bn' => '<strong class="text-amber-600">হ্যাঁ, অবশ্যই!</strong> যে কেউ আমাদের ক্যাম্পেইনে স্বেচ্ছাসেবক হতে পারবেন। অনেক কাজ অনলাইনেও করা যায়।',
                'color' => 'amber',
                'order' => 4,
            ],
            [
                'question' => 'Do I have to pay any fee to become a volunteer?',
                'question_bn' => 'স্বেচ্ছাসেবক হওয়ার জন্য কি কোনো ফি দিতে হবে?',
                'answer' => 'No, there is no fee to become a volunteer. It is completely free.',
                'answer_bn' => '<strong class="text-red-600">না,</strong> স্বেচ্ছাসেবক হওয়ার জন্য কোনো প্রকার ফি বা অর্থ প্রদান করতে হবে না। এটি সম্পূর্ণ <strong class="text-green-600">বিনামূল্যে।</strong>',
                'color' => 'red',
                'order' => 5,
            ],
            [
                'question' => 'How long after application will I be contacted?',
                'question_bn' => 'আবেদনের পর কতদিনে যোগাযোগ করা হবে?',
                'answer' => 'After submitting the application, our team will typically contact you within 2-3 business days.',
                'answer_bn' => 'আবেদন জমা দেওয়ার পর সাধারণত <strong class="text-teal-600">২-৩ কার্যদিবসের</strong> মধ্যে আমাদের টিম আপনার সাথে যোগাযোগ করবে।',
                'color' => 'teal',
                'order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }
    }
}
