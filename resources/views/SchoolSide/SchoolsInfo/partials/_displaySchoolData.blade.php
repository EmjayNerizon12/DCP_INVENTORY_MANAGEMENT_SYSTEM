<div id="school_others" class="sm:mx-5 mx-0">
	<div>
		<div class="page-title">Learners Data Form</div>
		<div class="page-subtitle">Please fill out and submit the guided form</div>
	</div>

	<button type="button" onclick="addSchoolData()" class="btn-submit py-1 px-4 rounded my-2">
		Add New Data
	</button>
	
		<div>

			<table class="w-full border-collapse border border-gray-800">
				<thead>
					<tr>
						<th class="td-cell uppercase whitespace-nowrap bg-green-200">Grade Level</th>
						<th class="td-cell uppercase whitespace-nowrap bg-red-200">Learners</th>
						<th class="td-cell uppercase whitespace-nowrap bg-blue-200">Teachers</th>
						<th class="td-cell uppercase whitespace-nowrap bg-purple-200">Sections</th>
						<th class="td-cell uppercase whitespace-nowrap bg-yellow-200">Classrooms</th>
						<th class="td-cell uppercase whitespace-nowrap bg-gray-200">Actions</th>
					</tr>
				</thead>
				<tbody>

					@forelse ($schoolData as $data)
						<tr>
							<td class="td-cell text-center">
								{{ collect($gradeLevels)->firstWhere('id', $data->GradeLevelID)['name'] ?? $data->GradeLevelID }}
							</td>
							<td class="td-cell text-center">{{ $data->RegisteredLearners }}</td>
							<td class="td-cell text-center">{{ $data->Teachers }}</td>
							<td class="td-cell text-center">{{ $data->Sections }}</td>
							<td class="td-cell text-center">{{ $data->Classrooms }}</td>
							<td class="td-cell text-center">
								<div class="flex gap-2 justify-center">
									<button title="Edit Data" class="btn-update py-1 px-4 rounded flex items-center"
										onclick="showEditForm({{ $data->ID }}, '{{ $data->GradeLevelID }}',{{ $data->RegisteredLearners }},{{ $data->Teachers }},{{ $data->Sections }},{{ $data->Classrooms }})">
										Edit

									</button>
									<button type="button" title="Remove Data" onclick="delete_school_data({{ $data->ID }})"
										class="btn-delete flex items-center  py-1 px-4 rounded">
										Delete
									</button>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td class="td-cell text-center" colspan="6">
								 No record found.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	 
</div>
