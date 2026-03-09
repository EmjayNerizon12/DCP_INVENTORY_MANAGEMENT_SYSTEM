<x-modal id="school-edit-modal" size="medium-modal" type="edit" icon="school-lg">
<div class="page-title">Edit School</div>
<div class="page-subtitle">Update school details</div>

<form id="school-edit-form" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="pk_school_id" id="edit_pk_school_id">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="form-label">School ID</label>
            <input type="text" name="SchoolID" id="edit_SchoolID" class="form-input" required>
        </div>
        <div>
            <label class="form-label">School Name</label>
            <input type="text" name="SchoolName" id="edit_SchoolName" class="form-input" required>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="form-label">School Level</label>
            <select name="SchoolLevel" id="edit_SchoolLevel" class="form-input" required>
                <option value="Elementary School">Elementary School</option>
                <option value="Junior High School">Junior High School</option>
                <option value="Senior High School">Senior High School</option>
            </select>
        </div>
        <div>
            <label class="form-label">Email Address</label>
            <input type="email" name="SchoolEmailAddress" id="edit_SchoolEmailAddress" class="form-input" required>
        </div>
    </div>

    <div class="modal-button-container">
        <button type="button" onclick="cancelSchoolEdit()" class="btn-cancel px-4 py-1 rounded">Cancel</button>
        <button type="submit" class="btn-green px-4 py-1 rounded">Update</button>
    </div>
</form>
</x-modal>