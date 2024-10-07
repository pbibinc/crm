 <!-- Company Header -->
 <div class="card border-0 shadow-sm rounded">
     <div class="card-body d-flex align-items-center justify-content-between p-3">
         <!-- Left side: Avatar and Company Info -->
         <div class="d-flex align-items-center">
             {{-- <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle me-3"> --}}
             <!-- Avatar -->
             <div>
                 <h6 class="mb-0 mt-4 fw-bold">{{ $leads->company_name }}.</h6>
                 <p><strong>{{ $leads->class_code }}</strong></p>

             </div>
         </div>

         <!-- Right side: Social Media Icons -->
         <div class="d-flex align-items-center">
             <a href="#" class="text-decoration-none text-primary me-3">
                 <i class="fas fa-phone"></i> {{ $leads->tel_num }} <!-- Twitter Icon -->
             </a>
             <a href="#" class="text-decoration-none text-primary me-3">
                 <i class="fas fa-envelope"></i> {{ $leads->GeneralInformation->email_address }}
             </a>
             <a href="#" class="text-decoration-none text-secondary">
                 <i class="bi bi-globe"></i> <!-- Website Icon -->
             </a>
         </div>
     </div>
     <div class="card">
         <div class="card-body d-flex align-items-center p-3 ">
             <!-- Additional Info Section -->
             <div class="d-flex align-items-center">
                 <span class="me-3"><i class="fas fa-user"></i>
                     {{ $leads->GeneralInformation->firstname . ' ' . $leads->GeneralInformation->lastname }}
                 </span>
                 <span class="me-3"> <i class="fas fa-briefcase"></i>
                     {{ $leads->GeneralInformation->job_position }}</span>

             </div>
         </div>
     </div>

 </div>
