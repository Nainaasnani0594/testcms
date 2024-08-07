<template>
    <div class="container mx-auto p-4">
      <div class="max-w-lg mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <div class="p-6">
            <h4 class="text-xl font-semibold mb-4 flex justify-between items-center">
              Create Permission
              <a href="{{ url('Permissions') }}" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                Back
              </a>
            </h4>
          </div>
          <div class="p-6">
            <form action="{{ url('permissions') }}" method="POST">
              @csrf
              <div class="mb-4">
                <label for="permission-name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                <input type="text" name="name" id="permission-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"/>
              </div>
              <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "PermissionForm",
  };
  </script>
  
  <style scoped>
  /* Custom styles (if any) */
  </style>
  