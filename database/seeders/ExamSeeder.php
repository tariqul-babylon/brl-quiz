<?php

namespace Database\Seeders;

use App\ExamHelper;
use App\Models\Exam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    use ExamHelper;

    public function run()
    {
        DB::transaction(function () {
            DB::table('exam_users')->delete();
            DB::table('exam_question_options')->delete();
            DB::table('exam_questions')->delete();
            DB::table('exams')->delete();
        });

        // Example data: 3 exams, each with questions and options
        $examsData = [
            [
                'title' => 'Mathematics Basic',
                'tagline' => 'Basic Math Exam',
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'instruction' => 'Answer all questions.',
                'full_mark' => 100,
                'negative_mark' => 0.25,
                'duration' => '01:30:00',
                'is_bluer' => false,
                'is_timer' => true,
                'exam_status' => 2,
                'user_result_view' => true,
                'user_answer_view' => true,
                'is_question_random' => true,
                'is_option_random' => true,
                'is_sign_in_required' => true,
                'is_specific_student' => false,
                'id_no_placeholder' => 'Enter ID',
                'logo' => null,
                'exam_link' => null,
                'exam_code' => 'EXAM01',
                'exam_source' => Exam::SOURCE_API,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Physics Intermediate',
                'tagline' => 'Physics Exam - Intermediate Level',
                'start_at' => now()->addDays(3),
                'end_at' => now()->addDays(4),
                'instruction' => 'No calculators allowed.',
                'full_mark' => 80,
                'negative_mark' => 0.1,
                'duration' => '02:00:00',
                'is_bluer' => true,
                'is_timer' => true,
                'exam_status' => 2,
                'user_result_view' => true,
                'user_answer_view' => false,
                'is_question_random' => false,
                'is_option_random' => true,
                'is_sign_in_required' => false,
                'is_specific_student' => true,
                'id_no_placeholder' => 'Student ID here',
                'logo' => null,
                'exam_link' => null,
                'exam_code' => 'EXAM02',
                'exam_source' => Exam::SOURCE_API,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'English Language',
                'tagline' => 'English Proficiency Test',
                'start_at' => now()->addDays(5),
                'end_at' => now()->addDays(6),
                'instruction' => 'Read all instructions carefully.',
                'full_mark' => 50,
                'negative_mark' => 0,
                'duration' => '01:00:00',
                'is_bluer' => false,
                'is_timer' => false,
                'exam_status' => 0,
                'user_result_view' => false,
                'user_answer_view' => false,
                'is_question_random' => false,
                'is_option_random' => false,
                'is_sign_in_required' => false,
                'is_specific_student' => false,
                'id_no_placeholder' => null,
                'logo' => null,
                'exam_link' => null,
                'exam_code' => 'EXAM03',
                'exam_source' => Exam::SOURCE_API,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            //3 data for web 
            [
                'title' => 'Mathematics Basic',
                'tagline' => 'Basic Math Exam',
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'instruction' => 'Answer all questions.',
                'full_mark' => 100,
                'negative_mark' => 0.25,
                'duration' => '01:30:00',
                'is_bluer' => false,
                'is_timer' => true,
                'exam_status' => 2,
                'user_result_view' => true,
                'user_answer_view' => true,
                'is_question_random' => true,
                'is_option_random' => true,
                'is_sign_in_required' => true,
                'is_specific_student' => false,
                'id_no_placeholder' => 'Enter ID',
                'logo' => null,
                'exam_link' => null,
                'exam_code' => 'EXAM04',
                'exam_source' => Exam::SOURCE_API,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Mathematics Basic',
                'tagline' => 'Basic Math Exam',
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'instruction' => 'Answer all questions.',
                'full_mark' => 100,
                'negative_mark' => 0.25,
                'duration' => '01:30:00',
                'is_bluer' => false,
                'is_timer' => true,
                'exam_status' => 2,
                'user_result_view' => true,
                'user_answer_view' => true,
                'is_question_random' => true,
                'is_option_random' => true,
                'is_sign_in_required' => true,
                'is_specific_student' => false,
                'id_no_placeholder' => 'Enter ID',
                'logo' => null,
                'exam_link' => null,
                'exam_code' => 'EXAM05',
                'exam_source' => Exam::SOURCE_API,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Mathematics Basic',
                'tagline' => 'Basic Math Exam',
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'instruction' => 'Answer all questions.',
                'full_mark' => 100,
                'negative_mark' => 0.25,
                'duration' => '01:30:00',
                'is_bluer' => false,
                'is_timer' => true,
                'exam_status' => 2,
                'user_result_view' => true,
                'user_answer_view' => true,
                'is_question_random' => true,
                'is_option_random' => true,
                'is_sign_in_required' => true,
                'is_specific_student' => false,
                'id_no_placeholder' => 'Enter ID',
                'logo' => null,
                'exam_link' => null,
                'exam_code' => 'EXAM06',
                'exam_source' => Exam::SOURCE_API,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        // Questions and options for each exam
        $questionsData = [
            // Mathematics Basic questions
            [
                [
                    'title' => 'What is 2 + 2?',
                    'question_type' => 0, // e.g. 0 = single choice, 1 = multiple choice
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
                [
                    'title' => 'What is the square root of 16?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
            ],

            // Physics Intermediate questions
            [
                [
                    'title' => 'What is the acceleration due to gravity on Earth?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '9.8 m/s²', 'is_correct' => true],
                        ['title' => '10 m/s²', 'is_correct' => false],
                        ['title' => '8.9 m/s²', 'is_correct' => false],
                    ],
                ],
                [
                    'title' => 'Which law explains the relationship between voltage, current and resistance?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => 'Newton’s Law', 'is_correct' => false],
                        ['title' => 'Ohm’s Law', 'is_correct' => true],
                        ['title' => 'Kepler’s Law', 'is_correct' => false],
                    ],
                ],
            ],

            // English Language questions
            [
                [
                    'title' => 'Select the correct spelling.',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => 'Accomodate', 'is_correct' => false],
                        ['title' => 'Accommodate', 'is_correct' => true],
                        ['title' => 'Acomodate', 'is_correct' => false],
                    ],
                ],
                [
                    'title' => 'Choose the correct synonym for "happy".',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => 'Sad', 'is_correct' => false],
                        ['title' => 'Joyful', 'is_correct' => true],
                        ['title' => 'Angry', 'is_correct' => false],
                    ],
                ],
            ],
            //3 data for api
            [
                [
                    'title' => 'What is 2 + 2?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
                [
                    'title' => 'What is the square root of 16?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
            ],
            //4 data for api
            [
                [
                    'title' => 'What is 2 + 2?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
                [
                    'title' => 'What is the square root of 16?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
            ],
            //5 data for api
            [
                [
                    'title' => 'What is 2 + 2?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
                [
                    'title' => 'What is the square root of 16?',
                    'question_type' => 0,
                    'status' => 1,
                    'options' => [
                        ['title' => '3', 'is_correct' => false],
                        ['title' => '4', 'is_correct' => true],
                        ['title' => '5', 'is_correct' => false],
                    ],
                ],
            ],
        ];

        foreach ($examsData as $index => $examData) {
            // Generate unique exam_code
            $examData['created_at'] = now();
            $examData['updated_at'] = now();

            // Insert exam and get ID
            $examId = DB::table('exams')->insertGetId($examData);

            // Insert questions and their options
            foreach ($questionsData[$index] as $question) {
                $options = $question['options'];
                unset($question['options']);

                $question['exam_id'] = $examId;
                $question['created_at'] = now();
                $question['updated_at'] = now();

                $questionId = DB::table('exam_questions')->insertGetId($question);

                foreach ($options as $option) {
                    $option['question_id'] = $questionId;
                    $option['created_at'] = now();
                    $option['updated_at'] = now();

                    DB::table('exam_question_options')->insert($option);
                }
            }
        }
    }

    private function generateUniqueExamCode($digits = 6)
    {
        do {
            $code = $this->makeExamCode($digits);
        } while (DB::table('exams')->where('exam_code', $code)->exists());

        return $code;
    }

    private function makeExamCode($digits = 6)
    {
        $characters = "123456789ABCDEF123456789GHJ123456789KMN123456789PQRST123456789UVW123456789XYZ123456789";
        $characters = str_shuffle($characters);
        $code = '';
        for ($i = 0; $i < $digits; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
}
