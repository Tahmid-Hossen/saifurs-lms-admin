<?php

namespace Database\Seeders;

use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class EBookTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');
        $status = Constants::$user_active_status;

        \DB::table('ebook_types')->insert([
            ['ebook_type_id' => '1', 'ebook_type_name' => 'Plain Text', 'extension' => 'TXT', 'content_type' => 'text/plain', 'ebook_type_description' => 'A plain text file is the simplest file format that uses the file extension .txt. These files are used strictly for text, images and graphs are not supported.', 'ebook_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['ebook_type_id' => '2', 'ebook_type_name' => 'Electronic publication (EPUB)', 'extension' => 'EPUB', 'content_type' => 'application/epub+zip', 'ebook_type_description' => 'An EPUB, or electronic publication, is the most widely supported eBook format and can be read on a variety of devices, including computers, smartphones, tablets, and most eReaders (except Kindles).', 'ebook_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['ebook_type_id' => '3', 'ebook_type_name' => 'MobiPocket File Format (MOBI)', 'extension' => 'MOBI', 'content_type' => 'application/mobi', 'ebook_type_description' => 'A MOBI file, otherwise known as a Mobipocket eBook file, was used as the first file format by Amazon when it launched Kindle. In 2011, support for the MOBI file was discontinued and has since been replaced by the AZW file format', 'ebook_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['ebook_type_id' => '4', 'ebook_type_name' => 'Amazon Kindle File Format (AZW3)', 'extension' => 'AZW3', 'content_type' => 'application/vnd.amazon.mobi8-ebook', 'ebook_type_description' => 'AZW files, also known as Kindle files, were developed by Amazon for its Kindle eReaders, replacing MOBI files. AZW files use the MOBI format, but contains DRM protection that only allows them to be read on Kindles or devices with Kindle apps', 'ebook_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['ebook_type_id' => '5', 'ebook_type_name' => 'Adobe Portable Document Format (PDF)', 'extension' => 'PDF', 'content_type' => 'application/pdf', 'ebook_type_description' => 'A PDF, also known as a portable document format, isn’t technically a true eBook because it’s not reflowable, but it’s the format most people are familiar with.', 'ebook_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['ebook_type_id' => '6', 'ebook_type_name' => 'MS Office Document (DOCX)', 'extension' => 'DOCX', 'content_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'ebook_type_description' => 'DOCX is a well-known format for Microsoft Word documents. Introduced from 2007 with the release of Microsoft Office 2007, the structure of this new Document format was changed from plain binary to a combination of XML and binary files', 'ebook_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
