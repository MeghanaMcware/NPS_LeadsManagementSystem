<!-- ================= COMMON SITE FOOTER ================= -->
<footer id="footer-section" class="footer-bg">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row align-items-center g-3">
            <div class="col-12 col-md-4">
                <a href="{{ url('/') }}" class="footer-brand" aria-label="National Public School home">
                    <img src="{{ asset('images/National Public School Emblem.png') }}" alt="NPS Logo" class="footer-logo" onerror="this.src='{{ asset('website/images/NPS_logo.png') }}'">
                    <span>
                        <span class="footer-name">National Public School</span>
                        <span class="footer-subtitle">Kempegowda Layout 7th Block</span>
                    </span>
                </a>
            </div>
            <div class="col-12 col-md-8">
                <div class="footer-details">
                    <span class="footer-item">
                        <i data-lucide="map-pin" class="icon icon-sm" aria-hidden="true" style="width:16px;height:16px;flex:none;"></i>
                        <span>7th Block, Sector 1, Bheemanakuppe, Kengeri Hobli, Bengaluru &#8211; 560 074, Karnataka</span>
                    </span>
                    <a href="tel:+919964227788" class="footer-item">
                        <i data-lucide="phone" class="icon icon-sm" aria-hidden="true" style="width:16px;height:16px;flex:none;"></i>
                        <span>+91 99642 27788 / +91 99646 42288</span>
                    </a>
                    <a href="mailto:info@npskgl.com" class="footer-item">
                        <i data-lucide="mail" class="icon icon-sm" aria-hidden="true" style="width:16px;height:16px;flex:none;"></i>
                        <span>info@npskgl.com / admissions@npskgl.com</span>
                    </a>
                    <a href="https://www.npskgl.com" target="_blank" rel="noopener noreferrer" class="footer-item">
                        <i data-lucide="globe" class="icon icon-sm" aria-hidden="true" style="width:16px;height:16px;flex:none;"></i>
                        <span>www.npskgl.com</span>
                    </a>
                    <span class="footer-item">
                        <i data-lucide="clock" class="icon icon-sm" aria-hidden="true" style="width:16px;height:16px;flex:none;"></i>
                        <span>Office Hours: Mon &#8211; Fri: 8:00 AM &#8211; 4:00 PM | Sat: 8:00 AM &#8211; 2:00 PM</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="border-top border-white-50 mt-3 pt-3 d-flex flex-wrap justify-content-between align-items-center text-white-50 small gap-2">
            <div>&copy; 2026 National Public School Kempegowda Layout. All rights reserved.</div>
            <div class="d-flex gap-3 flex-wrap footer-bottom-links">
                <a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a>
                <a href="{{ route('life_at_npskgl') }}" class="text-white-50 text-decoration-none">Life @ NPS KGL</a>
                <a href="{{ route('activities') }}" class="text-white-50 text-decoration-none">Activities</a>
                <a href="{{ url('/#admission-enquiry-box') }}" class="text-white-50 text-decoration-none">Admissions 2027-28</a>
            </div>
        </div>
    </div>
</footer>

<!-- ================= FLOATING WHATSAPP BUTTON ================= -->
<a href="https://wa.me/919964227788?text=Hello%20National%20Public%20School%20KGL%2C%20I%20would%20like%20to%20enquire%20about%20admissions." 
   target="_blank" 
   rel="noopener noreferrer" 
   class="nps-floating-whatsapp" 
   id="floatingWhatsappBtn"
   aria-label="Chat on WhatsApp with National Public School">
    <span class="whatsapp-pulse"></span>
    <svg class="whatsapp-icon-svg" viewBox="0 0 24 24" width="28" height="28" fill="currentColor" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.82 11.82 0 00-3.48-8.413z"/>
    </svg>
   
</a>

<style>
    /* FLOATING WHATSAPP STYLES */
    .nps-floating-whatsapp {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25d366;
        color: #ffffff !important;
        text-decoration: none !important;
        padding: 10px 10px 10px 10px;
        border-radius: 50px;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
        font-family: "Lato", Arial, sans-serif;
        font-weight: 700;
        font-size: 13.5px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .nps-floating-whatsapp:hover {
        background: #1ebc57;
        color: #ffffff !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 25px rgba(37, 211, 102, 0.6);
    }

    .whatsapp-pulse {
        position: absolute;
        inset: -3px;
        border-radius: 50px;
        background: rgba(37, 211, 102, 0.4);
        z-index: -1;
        animation: waPulse 2s infinite ease-in-out;
    }

    @keyframes waPulse {
        0% { transform: scale(0.96); opacity: 0.8; }
        50% { transform: scale(1.14); opacity: 0; }
        100% { transform: scale(0.96); opacity: 0; }
    }

    /* Keep back-to-top button stacked safely above WhatsApp if present */
    .btn-floating-top {
        bottom: 84px !important;
    }

    /* Mobile: condense to circle button */
    @media (max-width: 575.98px) {
        .nps-floating-whatsapp {
            padding: 12px;
            border-radius: 50%;
            bottom: 20px;
            right: 20px;
        }
        .nps-floating-whatsapp .whatsapp-label {
            display: none;
        }
        .whatsapp-pulse {
            border-radius: 50%;
        }
        .btn-floating-top {
            bottom: 80px !important;
            right: 20px !important;
        }
    }
</style>
