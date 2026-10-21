<?php
/**
 * "Book the job you need" hub and detail pages.
 * Same article shape as the blog: short answer, on-this-page, prose, FAQ.
 */

if (!defined('ABSPATH')) {
    exit;
}

function mbgroupltd_job_services()
{
    $phone = '<a href="tel:02081502025">020 8150 2025</a>';

    return [
        'boiler-installation' => [
            'title' => 'Boiler installation',
            'keyword' => 'boiler installation',
            'h1' => 'Boiler installation, fitted in a day',
            'image' => 'service-installation.png',
            'price' => 'From &pound;1,680*',
            'summary' => 'A-rated boilers fitted in a day by Gas Safe engineers.',
            'short' => 'A like-for-like combi boiler installation starts from £1,680 fully fitted. Gas Safe engineers agree a fixed price before any work starts, then fit, test and register the boiler.',
            'description' => 'Boiler installation from £1,680 fully fitted. Gas Safe engineers, a fixed price before we start, and most combi swaps done in a day.',
            'sections' => [
                ['What boiler installation includes', '<p>A MeraBoiler boiler installation covers the appliance, Gas Safe labour, a magnetic filter, a wireless thermostat, and the Gas Safety and Building Regulations certificates. The boiler is tested and registered with the manufacturer before we leave.</p><p>Most straightforward combi swaps are finished in a day. A system conversion, a flue move or extra radiators can take two to three days, and we confirm that plan in the written quote.</p>'],
                ['Boiler installation cost', '<p>Boiler installation cost depends on the model, the controls and whether pipework or the flue has to move. A like-for-like combi swap starts from £1,680. Worcester Bosch, Vaillant and Ariston are the ranges we fit most often, with a manufacturer guarantee of up to 12 years once the boiler is registered and serviced each year.</p><p>The price you accept is the price you pay for the agreed scope. If the survey shows extra work, we price that before we start.</p>'],
                ['Who carries out the boiler installation', '<p>Every boiler installation is done by a Gas Safe registered engineer. You can ask to see ID on arrival. We cover North London, Potters Bar and the surrounding postcodes, with same-day and next-day slots when the diary allows.</p><p>Call ' . $phone . ' or send the job details and we will come back with a fixed boiler installation price.</p>'],
            ],
            'faqs' => [
                ['How much does boiler installation cost?', 'A like-for-like combi swap starts from around £1,680 fully fitted. The written quote covers the boiler, labour, filter, thermostat and certificates.'],
                ['How long does boiler installation take?', 'Most combi swaps are done in a day. Conversions or flue moves usually take two to three days.'],
                ['Are your boiler installation engineers Gas Safe registered?', 'Yes. Every MeraBoiler engineer is Gas Safe registered and registers the new boiler before leaving.'],
            ],
        ],
        'boiler-repair' => [
            'title' => 'Boiler repair',
            'keyword' => 'boiler repair',
            'h1' => 'Boiler repair with a fixed price',
            'image' => 'service-repair.png',
            'price' => 'From &pound;85*',
            'summary' => 'Same-day diagnosis and repair with clear fixed pricing.',
            'short' => 'Boiler repair starts with a diagnosis from £85. You get a fixed price for the fault before any parts are fitted, including same-day visits when an engineer is free.',
            'description' => 'Boiler repair from £85. Same-day Gas Safe diagnosis and a fixed price for the fault before any parts are fitted.',
            'sections' => [
                ['What a boiler repair visit covers', '<p>The engineer checks the boiler, the flue and the obvious controls, then explains the fault in plain language. Boiler repair only goes ahead once you have accepted a fixed price for parts and labour.</p><p>Common jobs include ignition faults, diverter valves, pumps, pressure loss and frozen condensate pipes. If the boiler is not worth repairing, we say so and price a replacement instead.</p>'],
                ['Boiler repair cost', '<p>Boiler repair cost starts from £85 for diagnosis. The repair price depends on the part and the time on site, and it is agreed before we order or fit anything. There is no separate call-out surprise added at the end.</p>'],
                ['When to book a boiler repair', '<p>Book a boiler repair when you have heating or hot water but the boiler is locking out, losing pressure, or making a new noise. No heat and no hot water at all is treated as an emergency repair, and we aim to attend within the hour.</p><p>Call ' . $phone . ' and we will book the next available Gas Safe engineer.</p>'],
            ],
            'faqs' => [
                ['How much is a boiler repair?', 'Diagnosis starts from £85. The repair itself is a fixed price quoted before parts are fitted.'],
                ['Can you do a same-day boiler repair?', 'Yes, when an engineer is free in your area. We confirm the arrival window when you book.'],
                ['Do you repair all boiler brands?', 'We repair the common UK combi and system boilers, including Worcester Bosch, Vaillant, Ideal, Baxi and Ariston.'],
            ],
        ],
        'boiler-servicing' => [
            'title' => 'Boiler servicing',
            'keyword' => 'boiler servicing',
            'h1' => 'Annual boiler servicing',
            'image' => 'service-servicing.png',
            'price' => 'From &pound;69-120*',
            'summary' => 'Annual service to keep the guarantee and appliance safe.',
            'short' => 'Annual boiler servicing is £69 to £120 depending on the appliance. A Gas Safe engineer services, tests and records the visit so the manufacturer guarantee stays valid.',
            'description' => 'Annual boiler servicing from £69. Gas Safe service to keep the guarantee valid, with a written record of the visit.',
            'sections' => [
                ['What boiler servicing includes', '<p>Boiler servicing follows the manufacturer checklist: combustion analysis, burner and heat exchanger inspection, condensate trap, seals, flue, and the safety devices. You get a record of the readings and any advisory notes.</p><p>An annual service is what most warranties require. Miss a year and a later breakdown claim can be refused.</p>'],
                ['Boiler servicing cost', '<p>Boiler servicing cost is £69 to £120 for a standard domestic appliance. The exact figure depends on the boiler type. Landlord gas safety checks are a separate visit with their own certificate.</p>'],
                ['How often to book boiler servicing', '<p>Book boiler servicing once a year, ideally before the heating season. We cover homeowners and landlords across North London and Potters Bar.</p><p>Call ' . $phone . ' to book the next service slot.</p>'],
            ],
            'faqs' => [
                ['How much is boiler servicing?', 'A standard annual service is £69 to £120, confirmed when you book.'],
                ['Does boiler servicing keep the guarantee?', 'Yes. Most manufacturer guarantees require a recorded annual service by a Gas Safe engineer.'],
                ['How long does boiler servicing take?', 'A straightforward service usually takes under an hour, plus time to cool and retest the appliance.'],
            ],
        ],
        'smart-thermostat-fitting' => [
            'title' => 'Smart thermostat fitting',
            'keyword' => 'smart thermostat installation',
            'h1' => 'Smart thermostat installation',
            'image' => 'service-thermostat.png',
            'price' => 'Free survey',
            'summary' => 'Hive, Nest and manufacturer controls installed and paired.',
            'short' => 'Smart thermostat installation covers Hive, Nest and the boiler manufacturer’s own controls. We survey the wiring for free, then fit and pair the thermostat to the boiler.',
            'description' => 'Smart thermostat installation for Hive, Nest and manufacturer controls. Free survey, then fitting and pairing by a heating engineer.',
            'sections' => [
                ['What smart thermostat installation includes', '<p>Smart thermostat installation includes checking the existing programmer and boiler wiring, fitting the receiver, mounting the thermostat, and pairing the app. We leave the heating schedule running before we go.</p><p>Hive, Google Nest and the controls sold with Worcester Bosch and Vaillant are the systems we fit most often.</p>'],
                ['When a survey comes first', '<p>Older boilers and system boilers with a separate cylinder need a look at the wiring before we name a price. The survey is free. If the boiler cannot accept a smart control, we say so rather than forcing a replacement part.</p>'],
                ['Booking smart thermostat installation', '<p>Tell us the thermostat you want and the boiler model. We confirm whether it is a straight swap or needs the free survey first.</p><p>Call ' . $phone . ' or use the contact form with a photo of the current programmer.</p>'],
            ],
            'faqs' => [
                ['Which thermostats can you fit?', 'Hive, Google Nest, and the manufacturer controls for Worcester Bosch and Vaillant.'],
                ['Is the smart thermostat installation survey free?', 'Yes. We check the wiring at no charge and quote the fitting before any work starts.'],
                ['Will a smart thermostat work with my boiler?', 'Most combis do. We confirm compatibility from the boiler model, or on the free survey if the wiring is unusual.'],
            ],
        ],
        'power-flushing' => [
            'title' => 'Power flushing',
            'keyword' => 'power flushing',
            'h1' => 'Power flushing for cold radiators',
            'image' => 'service-powerflush.png',
            'price' => 'Quoted as a fixed price',
            'summary' => 'Remove sludge and restore heat to cold radiators.',
            'short' => 'Power flushing clears sludge from radiators and pipework. The job is quoted as a fixed price before we start, and the system is refilled with inhibitor afterwards.',
            'description' => 'Power flushing quoted as a fixed price. Clears radiator sludge, restores heat and refills the system with inhibitor.',
            'sections' => [
                ['What power flushing does', '<p>Power flushing pushes water and a cleaning chemical through the heating circuit to lift magnetite and sludge. Cold radiators at the bottom, noisy pumps and a new boiler fitted onto a dirty system are the usual reasons to book it.</p><p>We finish by draining, refilling and dosing inhibitor so the sludge does not return as quickly.</p>'],
                ['Power flushing cost', '<p>Power flushing cost is quoted as a fixed price after we know how many radiators you have. We do not start on an open-ended hourly rate. On a new boiler installation, we include the power flush in the quote when the system needs it.</p>'],
                ['Booking a power flush', '<p>Tell us the number of radiators and whether any stay cold at the bottom. We will price the power flushing visit before booking a date.</p><p>Call ' . $phone . ' to arrange it.</p>'],
            ],
            'faqs' => [
                ['How much does power flushing cost?', 'It is a fixed price based on the number of radiators, agreed before we start.'],
                ['Will power flushing fix cold radiators?', 'It fixes cold spots caused by sludge. A seized valve or a balancing problem is a different repair, and we will say which one you have.'],
                ['Do I need a power flush with a new boiler?', 'Only if the system is dirty. We check that on the installation survey and quote it separately if it is required.'],
            ],
        ],
        'underfloor-heating' => [
            'title' => 'Underfloor heating with a boiler',
            'keyword' => 'underfloor heating installation',
            'h1' => 'Underfloor heating installation with a boiler',
            'image' => 'service-underfloor.jpg',
            'price' => 'Free survey',
            'summary' => 'Wet underfloor heating connected to a combi or system boiler.',
            'short' => 'Underfloor heating installation for wet systems connected to a combi or system boiler. The survey is free, and the quote covers the manifold, controls and boiler connection.',
            'description' => 'Underfloor heating installation connected to a combi or system boiler. Free survey, then a fixed quote for the manifold and controls.',
            'sections' => [
                ['What underfloor heating installation includes', '<p>We connect wet underfloor heating to a combi or system boiler: manifold, actuators, room controls and the boiler flow temperature set for a floor circuit. This is a wet system, not electric mats.</p><p>The boiler has to be able to run at a lower flow temperature. Where it cannot, the quote includes the control changes needed.</p>'],
                ['Survey before a price', '<p>Underfloor heating installation is priced from a free survey because floor build-up, room size and the existing boiler all change the job. You get a fixed quote for the agreed rooms before any pipe is laid.</p>'],
                ['Where we fit underfloor heating', '<p>We fit underfloor heating with a boiler in North London and Potters Bar, usually as part of a renovation or a new extension.</p><p>Call ' . $phone . ' to book the survey.</p>'],
            ],
            'faqs' => [
                ['Can underfloor heating run from my combi boiler?', 'Yes, if the boiler can run at a lower flow temperature. The free survey confirms that.'],
                ['Is the underfloor heating survey free?', 'Yes. We measure the rooms and price the manifold, controls and boiler connection before work starts.'],
                ['Do you fit electric underfloor heating?', 'No. We install wet underfloor heating connected to a boiler.'],
            ],
        ],
        'central-heating-installation' => [
            'title' => 'Central heating installation',
            'keyword' => 'central heating installation',
            'h1' => 'Central heating installation',
            'image' => 'service-central-heating.jpg',
            'price' => 'Free survey',
            'summary' => 'Full central heating system with boiler, radiators and pipework.',
            'short' => 'Central heating installation covers a new boiler, radiators and pipework as one job. The survey is free and the quote is a fixed price for the system you agree.',
            'description' => 'Central heating installation with boiler, radiators and pipework. Free survey and a fixed price for the full system.',
            'sections' => [
                ['What central heating installation includes', '<p>A full central heating installation is the boiler, the radiators, the pipework, the controls and the certificates, quoted together. It is the right job for a house with no heating, or a system that is being replaced rather than repaired.</p><p>We design the radiator sizes around the rooms, not a one-size panel in every space.</p>'],
                ['Central heating installation cost', '<p>Central heating installation cost depends on the boiler, the number of radiators and how much pipework is new. The survey is free. You get one fixed price for the agreed system, with parts and labour listed, before we book the job.</p>'],
                ['How the job is booked', '<p>We survey, quote, then fit. First fix and second fix are planned so you know which days the heating will be off.</p><p>Call ' . $phone . ' to book a central heating survey.</p>'],
            ],
            'faqs' => [
                ['What is included in a central heating installation?', 'Boiler, radiators, pipework, controls and the Gas Safety and Building Regulations certificates for the agreed design.'],
                ['Do you survey before quoting?', 'Yes. The survey is free, and the quote that follows is a fixed price for that design.'],
                ['Can you add radiators to an existing system?', 'Yes. Extra radiators are priced on their own when the boiler and pipework can take them.'],
            ],
        ],
        'emergency-repair' => [
            'title' => 'Emergency repair',
            'keyword' => 'emergency boiler repair',
            'h1' => 'Emergency boiler repair',
            'image' => 'service-repair.png',
            'price' => 'Attendance within the hour',
            'summary' => 'No heating or hot water? We aim to attend within the hour.',
            'short' => 'Emergency boiler repair is for no heating or no hot water. We aim to attend within the hour, diagnose the fault, and give a fixed price before any repair goes ahead.',
            'description' => 'Emergency boiler repair when you have no heating or hot water. We aim to attend within the hour and quote a fixed price first.',
            'sections' => [
                ['When to call for emergency boiler repair', '<p>Call for an emergency boiler repair if you have no heating, no hot water, a smell of gas, or a leak you cannot isolate. If you smell gas, open windows, leave the property and call the National Gas Emergency number on 0800 111 999 before you call us.</p><p>A boiler that still runs but shows a fault code can wait for a standard boiler repair visit.</p>'],
                ['What happens on arrival', '<p>The Gas Safe engineer makes the situation safe, finds the fault and gives you a fixed price. Emergency boiler repair does not start until you accept that price. If the boiler cannot be repaired safely, we isolate it and price a replacement.</p>'],
                ['How fast we attend', '<p>We aim to attend within the hour across North London and Potters Bar while engineers are on shift. The phone team will tell you the real arrival window when you call, rather than a vague slot.</p><p>Call ' . $phone . ' now if you have no heat or hot water.</p>'],
            ],
            'faqs' => [
                ['How fast can you attend an emergency boiler repair?', 'We aim to be with you within the hour in North London and Potters Bar, and we confirm the window on the phone.'],
                ['Is there a call-out fee?', 'Diagnosis is priced before we leave you with a repair cost. The repair itself is a fixed price you accept first.'],
                ['What if I smell gas?', 'Leave the building and call 0800 111 999. Do not operate switches. Call us after the gas emergency service has made the supply safe.'],
            ],
        ],
    ];
}

function mbgroupltd_job_service($slug)
{
    $all = mbgroupltd_job_services();
    $slug = sanitize_title((string) $slug);
    return $all[$slug] ?? null;
}

function mbgroupltd_job_service_url($slug)
{
    return home_url('/services/' . sanitize_title((string) $slug) . '/');
}

function mbgroupltd_job_services_index_url()
{
    return home_url('/services/');
}

/**
 * Publish the services hub and one detail page per job.
 */
function mbgroupltd_ensure_job_service_pages()
{
    $version = 1;
    if ((int) get_option('mbgroupltd_job_services_version') === $version) {
        return;
    }

    $parent = get_page_by_path('services');
    if ($parent instanceof WP_Post) {
        $parent_id = (int) $parent->ID;
        if ($parent->post_status !== 'publish') {
            wp_update_post(['ID' => $parent_id, 'post_status' => 'publish']);
        }
    } else {
        $parent_id = wp_insert_post([
            'post_title' => 'Book the job you need',
            'post_name' => 'services',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
            'post_excerpt' => 'Book boiler installation, repair, servicing and heating jobs with Gas Safe engineers. Fixed prices and a clear scope before we start.',
            'post_author' => 1,
        ], true);
        if (is_wp_error($parent_id) || !$parent_id) {
            return;
        }
        $parent_id = (int) $parent_id;
    }

    update_post_meta($parent_id, '_wp_page_template', 'page-services.php');

    foreach (mbgroupltd_job_services() as $slug => $job) {
        $existing = get_page_by_path('services/' . $slug);
        $fields = [
            'post_title' => $job['h1'],
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_parent' => $parent_id,
            'post_excerpt' => $job['description'],
            'post_content' => '',
        ];
        if ($existing instanceof WP_Post) {
            $fields['ID'] = (int) $existing->ID;
            $page_id = wp_update_post($fields, true);
        } else {
            $fields['post_author'] = 1;
            $page_id = wp_insert_post($fields, true);
        }
        if (!is_wp_error($page_id) && $page_id) {
            update_post_meta((int) $page_id, '_wp_page_template', 'page-job-service.php');
        }
    }

    update_option('mbgroupltd_job_services_version', $version, false);
}
add_action('init', 'mbgroupltd_ensure_job_service_pages', 22);

function mbgroupltd_job_service_document_title($title)
{
    if (is_page('services')) {
        return 'Book the job you need | Boiler and heating services';
    }
    if (!is_page_template('page-job-service.php')) {
        return $title;
    }
    $job = mbgroupltd_job_service(get_post_field('post_name', get_queried_object_id()));
    if (!$job) {
        return $title;
    }
    return $job['h1'] . ' | MeraBoiler';
}
add_filter('pre_get_document_title', 'mbgroupltd_job_service_document_title', 110);
