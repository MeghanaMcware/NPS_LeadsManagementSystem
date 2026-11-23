<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>National Public School | Building Bright Futures</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <style>
    body, button, input, select, textarea {
      font-family: "Lato", Arial, sans-serif !important;
    }
  </style>
     <link rel="stylesheet" href="{{ asset('website/style.css') }}">
     <link rel="stylesheet" href="{{ asset('website/header.css') }}">
     @yield('style')
</head>

<body>

  <!-- PAGE LOADER -->
  <div id="pageLoader">
    <div class="loader-ring"></div>
    <div class="loader-text" id="loaderText">Loading...</div>
  </div>

 @include('frontend.layout.header')

 @yield('content')

    @include('frontend.layout.footer')


 




  <!-- ================= MODALS ================= -->

  <!-- OUR VISION -->
  <div class="modal fade nps-modal" id="visionModal" tabindex="-1" aria-labelledby="visionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="visionTitle"><i class="bi bi-eye"></i> Our Vision</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="vmv-icon" style="background:#e1f3d8;color:#3c8a1c"><i class="bi bi-lightbulb"></i></div>
          <p class="mb-0 text-center">Within an empowering child-centric environment, through numerous learning
            opportunities and best teaching practices, we strive to develop socially responsible, independent,
            knowledgeable, lifelong learners and leaders with multi-dimensional skills, values and integrity to
            positively impact and contribute AS GLOBAL CITIZENS.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-navy" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- OUR MISSION -->
  <div class="modal fade nps-modal" id="missionModal" tabindex="-1" aria-labelledby="missionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="missionTitle"><i class="bi bi-bullseye"></i> Our Mission</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="vmv-icon" style="background:#ece3ff;color:#7a45d6"><i class="bi bi-compass"></i></div>
          <ul>
            <li>Continuously evolve teaching learning strategies to equip students with skills and competencies in
              preparation for their entry into a world beyond School.</li>
            <li>Provide a plethora of opportunities to all students to develop the 21st century skills to transform
              themselves into value driven versatile well-grounded individuals</li>
            <li>Enhance staff competencies through rigorous professional development programmes laying emphasis on
              teacher training and leadership training</li>
            <li>Continue to build constructive relationships with all our stakeholders thereby creating a positive
              school climate which helps to extend a caring school community</li>
            <li>Enhance IT infrastructure and resources to augment student learning and assessments across scholastic
              and co-scholastic areas</li>
            <li>Strive towards impacting the community undertaking outreach initiatives and environmental projects in
              the neighbourhood.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-navy" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- OUR VALUES -->
  <div class="modal fade nps-modal" id="valuesModal" tabindex="-1" aria-labelledby="valuesTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="valuesTitle"><i class="bi bi-heart"></i> Our Values</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-center">NPS values of integrity, respect and excellence form the foundation of our community,
            fostering a culture of responsibility, empathy and collaboration. Through these core principles, we
            cultivate lifelong learners who embrace diversity, pursue knowledge and make positive contributions to
            society.</p>
          <h6 class="text-center border-0">Core Values</h6>
          <div class="values-grid">
            <span style="background:#14b38a">Excellence</span>
            <span style="background:#f5a800">NPS Core Values</span>
            <span style="background:#e8501a">Leadership</span>
            <span style="background:#e8286e">Community</span>
            <span style="background:#7b3fa6">Respect &amp; Responsibility</span>
            <span style="background:#5b3a99">Environmental Consciousness</span>
            <span style="background:#3b78c4">Creativity &amp; Innovation</span>
            <span style="background:#1696c9">Integrity</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-navy" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ADMISSION PROCESS -->
  <div class="modal fade nps-modal" id="admissionModal" tabindex="-1" aria-labelledby="admissionTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="admissionTitle"><i class="bi bi-file-earmark-text"></i> Admission Process</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Admission Process</h6>
          <p>Parents seeking admission for their child in NPS-National Public School for the Academic Year 2027-28 may
            please register OFF LINE for Pre-Primary to Grade IX. Online Registration now available.</p>

          <h6>Fees Details</h6>
          <p>Parents seeking admission for their child in NPS-National Public School for the Academic Year 2027-28 may
            please register OFF LINE for Pre-Primary to Grade IX. Online Registration now available.</p>

          <h6 class="text-uppercase">Process for Registration:</h6>
          <p>Read the guidelines and proceed to fill the registration form. (Please ensure that the names of student and
            parents are as per Aadhar card / Passport.)</p>
          <ul>
            <li>If registering on line, please Upload Aadhar Card, Birth Certificate.</li>
            <li>Caste certificate SC / ST/ OBC / Minority community</li>
            <li>Upload latest passport size photo.</li>
            <li>Submit the duly filled in form.</li>
            <li>Make Online payment of Rs. 10,800/- towards registration fees.</li>
            <li>Take a print out of the submitted form.</li>
            <li>Documents to be submitted to the school along with the print out of the Registration form duly signed
              by both parents:</li>
            <li>Copy of Aadhar Card</li>
            <li>Copy of Birth Certificate</li>
            <li>Caste Certificate if belong to SC/ ST/OBC/Minority community</li>
            <li>Copy of receipt of processing fee paid online</li>
            <li>Health report (if the child needs any special medical attention)</li>
            <li>Registration for admissions will be processed only after receiving the print out of the duly filled in
              registration form and the above mentioned documents. Exact date for registration will be announced in due
              course.</li>
          </ul>



           <h6 class="text-uppercase">OFFLINE REGISTRATION:</h6>
          <p>There is provision for offline registration.</p>
          <ul>
            <li>Parents can down load the form or can collect the Registration form on payment of Rs 10,800/- from the office.</li>
            <li>Tentatively from 17th September 2027 onwards between 9am to 5pm every working day. After filling up the form, submit the same along with the documents mentioned above .</li>
            
          </ul>

           <h6 class="text-uppercase">Office address:</h6>
          <p>NATIONAL PUBLIC SCHOOL</p>
          <p>Kempegowda Layout 7th Block Bangalore 560074</p>
          <p>+91 9964642288 / +91 9964227788</p>
          <p>info@npskgl.com</p>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-navy" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    /* ===== Page loader ===== */
    const loader = document.getElementById('pageLoader');
    const loaderText = document.getElementById('loaderText');

    function showLoader(msg) {
      loaderText.textContent = msg || 'Loading...';
      loader.classList.add('submit-mode');
      loader.classList.remove('hide');
    }
    function hideLoader() {
      loader.classList.add('hide');
      loader.classList.remove('submit-mode');
    }
    window.addEventListener('load', () => setTimeout(hideLoader, 500));
    // safety net - never let the loader get stuck
    setTimeout(hideLoader, 6000);

    /* ===== Enquiry form: Bootstrap 5 validation + SweetAlert2 ===== */
    const form = document.getElementById('enquiryForm');

    // allow digits only in mobile
    document.getElementById('mobile').addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        const firstInvalid = form.querySelector(':invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }
      form.classList.add('was-validated');

      showLoader('Submitting your enquiry...');
      const btn = document.getElementById('submitBtn');
      btn.disabled = true;

      /* Replace this setTimeout with your real request, e.g.
         fetch('/enquiry', { method:'POST', body:new FormData(form) }).then(...)  */
      setTimeout(() => {
        hideLoader();
        btn.disabled = false;
        Swal.fire({
          icon: 'success',
          title: 'Submitted Successfully!',
          text: 'Thank you for your enquiry. We will get back to you soon!',
          confirmButtonColor: '#0b2a6b',
          confirmButtonText: 'OK'
        }).then(() => {
          form.reset();
          form.classList.remove('was-validated');
        });
      }, 1500);
    }, false);

    // Clear the validation state when the form is reset
    form.addEventListener('reset', () => form.classList.remove('was-validated'));

    /* Scroll reveal */
    const io = new IntersectionObserver(e => e.forEach(x => { if (x.isIntersecting) { x.target.classList.add('show'); io.unobserve(x.target) } }), { threshold: .15 });
    document.querySelectorAll('.fade-up,.slide-l,.slide-r').forEach(el => io.observe(el));

    /* Testimonial slider */
    const testimonialRow = document.getElementById('tr');
    if (testimonialRow) {
      const updateVisibleTestimonials = () => {
        const visibleCount = window.matchMedia('(min-width: 768px)').matches ? 3 : 1;
        Array.from(testimonialRow.children).forEach((card, index) => {
          card.hidden = index >= visibleCount;
          card.setAttribute('aria-hidden', String(index >= visibleCount));
        });
      };

      window.shift = direction => {
        const cards = testimonialRow.children;
        if (cards.length < 2) {
          return;
        }

        if (direction > 0) {
          testimonialRow.appendChild(cards[0]);
        } else {
          testimonialRow.insertBefore(cards[cards.length - 1], cards[0]);
        }

        updateVisibleTestimonials();
      };

      updateVisibleTestimonials();
      window.addEventListener('resize', updateVisibleTestimonials);

      const testimonialSection = testimonialRow.closest('.testi');
      if (testimonialSection && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.setInterval(() => {
          if (
            !document.hidden &&
            !testimonialSection.matches(':hover') &&
            !testimonialSection.contains(document.activeElement)
          ) {
            window.shift(1);
          }
        }, 5000);
      }
    }

    /* Navbar shadow + active link */
    const links = document.querySelectorAll('.nav-link');
    addEventListener('scroll', () => {
      document.getElementById('nav').style.boxShadow = scrollY > 10 ? '0 4px 20px rgba(11,42,107,.15)' : '';
      document.querySelectorAll('section[id]').forEach(s => {
        const r = s.getBoundingClientRect();
        if (r.top < 150 && r.bottom > 150) links.forEach(l => l.classList.toggle('active', l.getAttribute('href') === '#' + s.id))
      })
    });
  </script>
</body>

</html>
