@extends('frontend.layout.app')

@section('style')
@endsection

@section('content')
 <!-- HERO -->
  <section class="hero" id="home">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-7 slide-l">
          <div class="eyebrow"><i class="bi bi-book"></i> A PLACE TO LEARN &nbsp; <i class="bi bi-flower1"></i> A SPACE
            TO GROW</div>
          <h1>National Public School<br>Building Bright Futures</h1>
          <p class="lead">We provide a nurturing environment where children learn, explore and grow into confident,
            compassionate and responsible global citizens.</p>
          <div class="row g-3 my-4">
            <div class="col-12 col-sm-4">
              <div class="hero-feat"><i class="bi bi-book-half"></i>
                <div><b>CBSE Curriculum</b><small>Future Ready</small></div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="hero-feat"><i class="bi bi-person-check"></i>
                <div><b>Experienced Faculty</b><small>Expert Guidance</small></div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="hero-feat"><i class="bi bi-shield-check"></i>
                <div><b>Safe Campus</b><small>Secure &amp; Caring</small></div>
              </div>
            </div>
          </div>
          <div class="d-flex flex-wrap align-items-center gap-4">
            <!-- <a href="#about" class="btn btn-yellow">Explore Our School <i class="bi bi-arrow-right ms-1"></i></a> -->
            <!-- <a href="#" class="watch d-flex align-items-center gap-2"><span class="play"><i
                  class="bi bi-play-fill"></i></span> Watch Video</a> -->
          </div>
        </div>
        <div class="col-lg-5 col-xl-4 offset-xl-1 slide-r d2">

          <!-- ADMISSION ENQUIRY FORM (Bootstrap 5 validation) -->
          <form class="enquiry needs-validation" id="enquiryForm" novalidate>
            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-person-plus-fill fs-2 text-success"></i>
              <div>
                <h5>Admission Enquiry</h5><small style="font-size:.72rem">Take the first step towards a brighter
                  future</small>
              </div>
            </div>

            <div class="field">
              <i class="bi bi-person"></i>
              <input class="form-control" id="studentName" name="student_name" placeholder="Student Name *" required
                minlength="3" maxlength="50" pattern="[A-Za-z .]{3,50}">
              <div class="invalid-feedback">Please enter a valid student name (letters only, min 3 characters).</div>
            </div>

            <div class="field">
              <i class="bi bi-person-heart"></i>
              <input class="form-control" id="parentName" name="parent_name" placeholder="Parent Name *" required
                minlength="3" maxlength="50" pattern="[A-Za-z .]{3,50}">
              <div class="invalid-feedback">Please enter a valid parent name (letters only, min 3 characters).</div>
            </div>

            <div class="field">
              <i class="bi bi-phone"></i>
              <input class="form-control" id="mobile" name="mobile" type="tel" inputmode="numeric"
                placeholder="Mobile Number *" required maxlength="10" pattern="[6-9][0-9]{9}">
              <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
            </div>

            <div class="field">
              <i class="bi bi-backpack"></i>
              <select class="form-select" id="classApplying" name="class_applying" required>
                <option value="">Class Applying For *</option>
                <option>Nursery</option>
                <option>LKG / UKG</option>
                <option>Class I – V</option>
                <option>Class VI – X</option>
              </select>
              <div class="invalid-feedback">Please select a class.</div>
            </div>

            <button type="submit" class="btn btn-navy" id="submitBtn">Submit Enquiry <i
                class="bi bi-arrow-right ms-1"></i></button>

            <!-- Admission Process button (above the text) -->
            <button type="button" class="btn-admission mt-3" data-bs-toggle="modal"
              data-bs-target="#admissionModal"><i class="bi bi-file-earmark-text me-1"></i> Admission Process</button>

            <p class="text-center mt-3 mb-0" style="font-size:.72rem">We will get back to you soon!</p>
          </form>

        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about" id="about">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-6 slide-l">
          <div class="tag">About NPS</div>
          <h2 class="sec-title"> About National Public School (NPS)</h2>
          <p style="max-width:auto;text-align: justify;">NPS started its journey in the year 1959 under the pioneering
            effort and careful
            nurturing by our Founder Chairman Dr. K P Gopalkrishna and Senior Principal Dr. Santhamma Gopalkrishna. NPS
            Rajajinagar has been known for its academic excellence, discipline and ethical practices.</p>
          <p style="max-width:auto;text-align: justify;">Today NPS has more than 1800 students on its roll and has the
            honour of being
            granted Autonomous status by the CBSE, Govt. of India. This is an honour given only to two schools in the
            country of which NPS Rajajinagar is one. Every year batches of students leave its portals as assured
            confident young citizens, ready to take on the challenges of life and equipped with an enduring set of
            values.</p>
          <p style="max-width:auto;text-align: justify;">Our alumni have spread to all walks of life ranging from IT and
            medicine to fashion
            designing, from law to theatre. They have proved to be effective leaders and successful entrepreneurs in
            various fields. Our guiding principle at NPS is to ensure that our students go forth out into the wider
            community empowered with a sense of ambition, confidence and absolute faith in their own innate abilities to
            pursue and follow the paths they have chosen for themselves</p>

          <!-- Vision / Mission / Values - click opens modal -->
          <div class="row g-2 my-4 text-center">
            <div class="col-6 col-sm-3">
              <button type="button" class="mini" data-bs-toggle="modal" data-bs-target="#visionModal">
                <div class="ico" style="background:#e1f3d8;color:#3c8a1c"><i class="bi bi-eye"></i></div>
                Our Vision
              </button>
            </div>
            <div class="col-6 col-sm-3">
              <button type="button" class="mini" data-bs-toggle="modal" data-bs-target="#missionModal">
                <div class="ico" style="background:#ece3ff;color:#7a45d6"><i class="bi bi-bullseye"></i></div>
                Our Mission
              </button>
            </div>
            <div class="col-6 col-sm-3">
              <button type="button" class="mini" data-bs-toggle="modal" data-bs-target="#valuesModal">
                <div class="ico" style="background:#ffe9d6;color:#ee7a1a"><i class="bi bi-heart"></i></div>
                Our Values
              </button>
            </div>
          </div>

        </div>
        <div class="col-lg-6 slide-r d2">
          <div class="">
            <img src="{{ asset('website/images/Better_Learners_Brighter_Tomorrow_new.png') }}" width="100%" alt="Better Learners, Brighter Tomorrow">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- JOURNEY -->
  <section class="journey" id="journey">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-4 journey-copy fade-up">
          <div class="tag">The Children's Journey</div>
          <h2 class="sec-title">From Curiosity to<br>Confidence</h2>
          <p>At National Public School, we support every child's unique journey with
            personalized learning, expert guidance and countless opportunities to explore, learn and grow.</p>
          <a href="#" class="btn btn-navy mb-3">Explore Our Approach <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="col-lg-5">
          <div class="row journey-steps g-3">
            <div class="col-6 col-xl-3 fade-up d1">
              <div class="step">
                <div class="circ" style="background:#ffc21a"><i class="bi bi-lightbulb"></i></div>
                <h6>Discover</h6><small>Spark curiosity and interest</small><i class="bi bi-chevron-right arrow"></i>
              </div>
            </div>
            <div class="col-6 col-xl-3 fade-up d2">
              <div class="step">
                <div class="circ" style="background:#1a6fe0;animation-delay:.3s"><i class="bi bi-book"></i></div>
                <h6>Learn</h6><small>Build strong foundations</small><i class="bi bi-chevron-right arrow"></i>
              </div>
            </div>
            <div class="col-6 col-xl-3 fade-up d3">
              <div class="step">
                <div class="circ" style="background:#3f9b3a;animation-delay:.6s"><i class="bi bi-flower3"></i></div>
                <h6>Grow</h6><small>Develop skills and confidence</small><i class="bi bi-chevron-right arrow"></i>
              </div>
            </div>
            <div class="col-6 col-xl-3 fade-up d4">
              <div class="step">
                <div class="circ" style="background:#8a3fe0;animation-delay:.9s"><i class="bi bi-star"></i></div>
                <h6>Achieve</h6><small>Reach goals and beyond</small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 journey-art">
          <div class="journey-note hand">Small Steps<br>Big Dreams</div>
          <i class="bi bi-send-fill journey-plane" aria-hidden="true"></i>
          <div class="journey-img" aria-hidden="true"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- WHY -->
  <section class="why" id="why">
    <div class="container">
      <div class="row g-4 align-items-start">
        <div class="col-lg-3 fade-up">
          <div class="tag">Our Highlights</div>
          <h2 class="sec-title">Why Choose NPS?</h2>
          <p style="font-size:.85rem">A perfect blend of academic excellence, modern facilities and values-based
            education.</p>
          <a href="#" class="btn btn-green">Discover More <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="col-lg-9">
          <div class="row g-3">
            <div class="col-6 col-md-3 fade-up d1">
              <div class="why-card"><i class="bi bi-mortarboard-fill"></i><b>Academic Excellence</b><small>CBSE
                  Curriculum (Classes I – X)</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d2">
              <div class="why-card"><i class="bi bi-easel2"></i><b>Modern Classrooms</b><small>Smart &amp; Digital
                  Learning</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d3">
              <div class="why-card"><i class="bi bi-person-arms-up"></i><b>Sports &amp; Fitness</b><small>Indoor &amp;
                  Outdoor Sports</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d4">
              <div class="why-card"><i class="bi bi-journal-bookmark-fill"></i><b>Library &amp; Resources</b><small>Rich
                  Library &amp; Study Resources</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d1">
              <div class="why-card"><i class="bi bi-palette-fill"></i><b>Arts &amp; Culture</b><small>Talent &amp;
                  Creativity</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d2">
              <div class="why-card"><i class="bi bi-shield-fill-check"></i><b>Safe Campus</b><small>CCTV &amp; Trained
                  Staff</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d3">
              <div class="why-card"><i class="bi bi-bus-front-fill"></i><b>Transport Facility</b><small>Safe &amp;
                  Reliable</small></div>
            </div>
            <div class="col-6 col-md-3 fade-up d4">
              <div class="why-card"><i class="bi bi-heart-pulse-fill"></i><b>Wellness &amp; Care</b><small>Physical
                  &amp; Mental Health</small></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testi" id="testi">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-3 fade-up">
          <div class="tag">Parent's Testimonials</div>
          <h2 class="sec-title">What Parents Say</h2>
          <p style="font-size:.85rem">Real stories. Genuine smiles. Our greatest joy is seeing our students and parents
            happy.</p>
          <a href="#" class="btn btn-navy">Read More Testimonials <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="col-lg-9">
          <div class="row g-3" id="tr">
            <div class="col-md-4 fade-up d1">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>As parents of Parthiv, we are delighted with his experience at NPS, Kempegowda Layout. The caring teachers, personal attention, and positive environment have helped him grow in confidence and enthusiasm for learning. We are happy to have chosen NPS for his overall development.
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/teacher.png') }}"></div>
                  <div><b class="text-dark">Mr. Shrikanth and Anusha, </b><br><small>Parents of Parthiv</small></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 fade-up d2">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>Since joining NPS, Kempegowda Layout, Rishikesh has grown more confident, responsible, and expressive. We truly appreciate the school’s focus on leadership, values, and overall development.
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/man.png') }}"></div>
                  <div><b class="text-dark">Mr. Suneel Reddy and Mrs. Meghana, </b><br><small>Parents of Rishikesh</small></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 fade-up d3">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>We always wished our son, Raghav, to study at NPS, and that dream has now come true with NPS Kempegowda Layout. We are extremely happy and grateful to see him grow and learn in such a wonderful environment.
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/teacher.png') }}"></div>
                  <div><b class="text-dark">Mr. Praveen and Mrs. Anupama, </b><br><small>Parents of Raghav Praveen</small></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 fade-up d3">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>I wanted to sincerely thank all of the teachers for the amazing impact they have had on Aadhira's life. Her behavior, communication abilities, and capacity for logical thought and response have all changed dramatically. I truly think your advice.
                            
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/teacher.png') }}"></div>
                  <div><b class="text-dark">Aadhira Mahajan's Mother</b><br><small>Parents of Aadhira</small></div>
                </div>
              </div>
            </div>

            <div class="col-md-4 fade-up d3">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>As her parents, we have witnessed a significant shift in Advika, as she has begun to exhibit bravery, an interest in outdoor pursuits, and a willingness to learn. We want to express our gratitude for supporting my child.
                            
                            
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/teacher.png') }}"></div>
                  <div><b class="text-dark">Advika's Mother</b></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 fade-up d3">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>I wanted to express the happiness and contentment my child and I have been experiencing ever since he joined NPSKGL. Since Dhanesh was not very eager to relocate to India, getting to NPSKGL was not an easy decision.
                            
                            
                            
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/teacher.png') }}"></div>
                  <div><b class="text-dark">Dhanesh's Mother</b></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 fade-up d3">
              <div class="t-card">
                <div class="q"><i class="bi bi-quote"></i></div>
                <p>Thank you for nurturing 
                                our child's love for learning. Our child feels uplifted at the school, the dedication of the
                                teachers is commendable,
                                my child is very happy, the teaching staff are very good at developing the children's academic skills as well as social interaction
                                and productive play.
                            
                            
                            
                            </p>
                <div class="stars">★★★★★</div>
                <div class="d-flex align-items-center gap-2 mt-2">
                  <div class="avatar"><img src="{{ asset('website/images/teacher.png') }}"></div>
                  <div><b class="text-dark">Parent of Dhrithi</b></div>
                </div>
              </div>
            </div>
          </div>
          <div class="testimonial-controls d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="arr" onclick="shift(-1)" aria-label="Previous testimonial">
              <i class="bi bi-chevron-left" aria-hidden="true"></i>
            </button>
            <button type="button" class="arr arr-next" onclick="shift(1)" aria-label="Next testimonial">
              <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection



@push('scripts')

@endpush