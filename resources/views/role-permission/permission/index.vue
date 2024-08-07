<template>
    <div class="container mx-auto p-4">
      <div class="max-w-lg mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          
          <!-- Session Status -->
          <div v-if="sessionStatus" class="alert alert-success p-4 mb-4 bg-green-100 text-green-700 rounded">
            {{ sessionStatus }}
          </div>
  
          <!-- Header -->
          <div class="p-6">
            <h4 class="text-xl font-semibold mb-4 flex justify-between items-center">
              Permission
              <a href="{{ url('Permissions/create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Add Permission
              </a>
            </h4>
          </div>
  
          <!-- Table -->
          <div class="p-6">
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">Id</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">Name</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="permission in permissions" :key="permission.id" class="border-b">
                    <td class="py-2 px-4">{{ permission.id }}</td>
                    <td class="py-2 px-4">{{ permission.name }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ url('permission/'.permission.id.'/edit') }}" class="btn btn-success">Edit</a>
                        <a href="">Delete</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
  
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "PermissionIndex",
    props: {
      sessionStatus: String,
      permissions: Array
    }
  };
  </script>
  
  <style scoped>
  /* Custom styles (if any) */
  .alert {
    background-color: #f0fff4;
    border-color: #c6f6d5;
    color: #38a169;
  }
  </style>
  