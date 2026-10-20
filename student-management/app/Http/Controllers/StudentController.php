<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    //READ: Display all students
    public function index()
    {
        $students = Student::latest()->get();

        return view('students.index', compact('students'));
    }

    //CREATE: Show the form
    public function create()
    {
        return view('students.create');
    }

    //CREATE: Save a new student
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_number' =>
    'required|string|max:50|unique:students,student_number',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' =>
    'required|email|max:255|unique:students,email',
            'course' => 'required|string|mas:255',
        ]);

        Student::create($validated);
        return redirect()->route('students.index')
            ->with('success', 'Student added successfully!');
    }

    //READ: Display a specific student
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    //UPDATE: Show the edit form
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    //UPDATE: Save changes
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_number' => [
            'required',
            'string',
            'max:50',
            Rule::unique('students', 'student_number')->ignore($student->id),
        ],
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('students', 'email')->ignore($tudent->id),
        ],
        'course' => 'required|string|max:255',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    //DELETE: Remove a student
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('succcess', 'Student deleted successfully!');
    }
}