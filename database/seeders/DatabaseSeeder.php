<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\ConstructionUpdate;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyUnit;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'admin@alnoorbd.com'],
            [
                'name' => 'Al-Noor Executive Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Categories
        $categories = [
            [
                'name' => 'Signature Residential',
                'description' => 'Ultra-luxury high-rise condominiums, sky-suites & boutique duplex residences tailored for Dhaka’s elite.',
                'is_active' => true,
            ],
            [
                'name' => 'Commercial Landmark',
                'description' => 'Grade-A corporate headquarters, smart offices, and premium retail hubs in Dhaka’s central business districts.',
                'is_active' => true,
            ],
            [
                'name' => 'Sky Penthouses & Duplexes',
                'description' => 'Exclusive top-tier multi-level penthouses with private rooftop pools, double-height ceilings, and panoramic city views.',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Villa Estates',
                'description' => 'Gated community luxury villas and garden residences crafted with private green lawns and serene exclusivity.',
                'is_active' => true,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['name']] = Category::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // 3. Dhaka Prime Locations
        $locations = [
            [
                'name' => 'Gulshan 2',
                'city' => 'Dhaka',
                'latitude' => 23.7925,
                'longitude' => 90.4152,
                'is_active' => true,
            ],
            [
                'name' => 'Banani',
                'city' => 'Dhaka',
                'latitude' => 23.7937,
                'longitude' => 90.4066,
                'is_active' => true,
            ],
            [
                'name' => 'Dhanmondi',
                'city' => 'Dhaka',
                'latitude' => 23.7461,
                'longitude' => 90.3742,
                'is_active' => true,
            ],
            [
                'name' => 'Bashundhara R/A',
                'city' => 'Dhaka',
                'latitude' => 23.8191,
                'longitude' => 90.4357,
                'is_active' => true,
            ],
            [
                'name' => 'Uttara',
                'city' => 'Dhaka',
                'latitude' => 23.8759,
                'longitude' => 90.3795,
                'is_active' => true,
            ],
            [
                'name' => 'Purbachal',
                'city' => 'Dhaka',
                'latitude' => 23.8340,
                'longitude' => 90.5120,
                'is_active' => true,
            ]
        ];

        $locationModels = [];
        foreach ($locations as $loc) {
            $locationModels[$loc['name']] = Location::updateOrCreate(['name' => $loc['name']], $loc);
        }

        // 4. Properties Data
        $properties = [
            [
                'name' => 'Al-Noor Crown Palace',
                'short_description' => 'A Testament to Regal Living in Diplomatic Gulshan-2 with Heated Infinity Pool & Panoramic Skyline Vistas.',
                'description' => 'Al-Noor Crown Palace represents the zenith of architectural luxury in Dhaka’s most coveted residential quadrant. Designed for discerning families who demand peerless privacy, uncompromised safety, and expansive spatial grandeur. Featuring triple-height double-glazed thermal façades, Japanese Mitsubishi VRF climate conditioning, Italian Statuario marble lobby, and a temperature-controlled infinity sky pool overlooking Gulshan Lake.',
                'category_name' => 'Signature Residential',
                'location_name' => 'Gulshan 2',
                'address' => 'Plot 14, Road 84, Gulshan-2 Diplomatic Zone, Dhaka',
                'status' => 'ongoing',
                'type' => 'residential',
                'land_area' => 18.00,
                'land_unit' => 'katha',
                'total_floors' => 18,
                'apartments_per_floor' => 2,
                'total_units' => 32,
                'price_from' => 48500000.00,
                'price_to' => 125000000.00,
                'price_label' => 'Starting from BDT 4.85 Crore',
                'progress_percentage' => 42,
                'launch_date' => '2025-01-15',
                'expected_completion' => '2027-12-31',
                'handover_date' => '2027-12-31',
                'is_featured' => true,
                'is_special_offer' => false,
                'is_published' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1400&q=85',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'brochure_pdf' => '#',
                'latitude' => 23.7960,
                'longitude' => 90.4180,
                'sort_order' => 1,
                'published_at' => now(),
                'amenities' => [
                    'Rooftop Infinity Sky Pool',
                    'Private Wellness Spa & Sauna',
                    'Technogym Equipped Fitness Centre',
                    'Children’s Indoor Creative Playground',
                    'Executive Banquet & Event Lounge',
                    'EV Fast Charging Bays (x4)',
                    '3-Tier Biometric Security & CCTV',
                    '100% Full Generator Power Backup',
                    'Landscaped Zen Terrace Gardens',
                    'Double Glazed Acoustic Glass Windows'
                ],
                'nearby_landmarks' => [
                    ['name' => 'American Club & Diplomatic Zone', 'distance' => '2 mins'],
                    ['name' => 'Gulshan Club', 'distance' => '4 mins'],
                    ['name' => 'United Hospital', 'distance' => '5 mins'],
                    ['name' => 'Unimart & Chef\'s Table Gulshan', 'distance' => '3 mins'],
                    ['name' => 'International School Dhaka (ISD)', 'distance' => '12 mins'],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Exterior Architectural Rendering - Evening View', 'type' => 'exterior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Grand Double-Height Living Room with Skyline Views', 'type' => 'interior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Bespoke Italian Kitchen & Breakfast Bar', 'type' => 'interior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Master Bedroom Suite with Private Balcony', 'type' => 'interior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Rooftop Infinity Edge Pool & Sun Deck', 'type' => 'amenity'],
                ],
                'units' => [
                    [
                        'unit_type' => 'Royal Suite (Type A)',
                        'size_sqft' => 3850,
                        'bedrooms' => 4,
                        'bathrooms' => 5,
                        'balconies' => 4,
                        'parking_spaces' => 3,
                        'price' => 58000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 1
                    ],
                    [
                        'unit_type' => 'Imperial Suite (Type B)',
                        'size_sqft' => 2950,
                        'bedrooms' => 3,
                        'bathrooms' => 4,
                        'balconies' => 3,
                        'parking_spaces' => 2,
                        'price' => 48500000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 2
                    ],
                    [
                        'unit_type' => 'Crown Sky Penthouse',
                        'size_sqft' => 5800,
                        'bedrooms' => 5,
                        'bathrooms' => 6,
                        'balconies' => 5,
                        'parking_spaces' => 4,
                        'price' => 125000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 3
                    ],
                ],
                'construction_updates' => [
                    [
                        'title' => 'Structural Superstructure Reaches Level 12',
                        'description' => 'Reinforced concrete casting completed for the 12th residential floor slab. High-strength post-tensioning tendons tensioned and grouted.',
                        'milestone' => 'structure',
                        'progress_percentage' => 42,
                        'update_date' => '2026-09-15',
                        'photos' => ['https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80']
                    ],
                    [
                        'title' => 'Basement 3-Level Substructure & Retaining Walls Finished',
                        'description' => 'Tri-level deep basement excavation, secant pile walls, and basement waterproofing membranes completed with zero water ingress test passed.',
                        'milestone' => 'foundation',
                        'progress_percentage' => 25,
                        'update_date' => '2026-05-20',
                        'photos' => ['https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=800&q=80']
                    ],
                ]
            ],
            [
                'name' => 'Al-Noor Lakefront Mirage',
                'short_description' => 'Uninterrupted Water Horizons in Banani Road 11 with Expansive Cantilevered Sky Gardens.',
                'description' => 'Al-Noor Lakefront Mirage combines the soothing tranquility of Banani Lake with ultra-contemporary urban minimalism. Every residence is meticulously positioned to offer unobstructed water horizons, generous 8-foot cantilevered landscaped balconies, and soundproof acoustic glass windows. The building features an elevated waterfront boardwalk, private clubhouse, and heated therapeutic plunge pool.',
                'category_name' => 'Signature Residential',
                'location_name' => 'Banani',
                'address' => 'Road 11, Block E, Banani Lake Promenade, Dhaka',
                'status' => 'ongoing',
                'type' => 'residential',
                'land_area' => 14.50,
                'land_unit' => 'katha',
                'total_floors' => 15,
                'apartments_per_floor' => 2,
                'total_units' => 26,
                'price_from' => 39500000.00,
                'price_to' => 86000000.00,
                'price_label' => 'Starting from BDT 3.95 Crore',
                'progress_percentage' => 58,
                'launch_date' => '2025-03-01',
                'expected_completion' => '2027-08-30',
                'handover_date' => '2027-08-30',
                'is_featured' => true,
                'is_special_offer' => true,
                'is_published' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1400&q=85',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'brochure_pdf' => '#',
                'latitude' => 23.7942,
                'longitude' => 90.4078,
                'sort_order' => 2,
                'published_at' => now(),
                'amenities' => [
                    'Waterfront Plunge Pool',
                    'Private Residents Clubhouse',
                    'Sky Deck Meditation Corner',
                    'Smart Car Parking Guidance System',
                    'Billiard & Card Room',
                    '24/7 Security & CCTV',
                    'Automated Smart Home Pre-wiring'
                ],
                'nearby_landmarks' => [
                    ['name' => 'Banani Road 11 Fine Dining District', 'distance' => '1 min'],
                    ['name' => 'Banani Club', 'distance' => '3 mins'],
                    ['name' => 'Sheraton Dhaka Banani', 'distance' => '4 mins'],
                    ['name' => 'Kemal Ataturk Avenue', 'distance' => '3 mins'],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Lakefront Exterior Elevation', 'type' => 'exterior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Open Concept Waterfront Dining & Living', 'type' => 'interior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Master Bedroom Overlooking Lake', 'type' => 'interior'],
                ],
                'units' => [
                    [
                        'unit_type' => 'Lakeview Grande (Type A)',
                        'size_sqft' => 3450,
                        'bedrooms' => 4,
                        'bathrooms' => 4,
                        'balconies' => 4,
                        'parking_spaces' => 2,
                        'price' => 52000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 1
                    ],
                    [
                        'unit_type' => 'Lakeview Elite (Type B)',
                        'size_sqft' => 2600,
                        'bedrooms' => 3,
                        'bathrooms' => 3,
                        'balconies' => 3,
                        'parking_spaces' => 2,
                        'price' => 39500000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 2
                    ],
                ],
                'construction_updates' => [
                    [
                        'title' => 'Curtain Glass Glazing & Terraces Landscaping in Progress',
                        'description' => 'Façade double-glazed glass installation completed up to 10th floor. Planter box waterproofing and soil integration ongoing.',
                        'milestone' => 'finishing',
                        'progress_percentage' => 58,
                        'update_date' => '2026-09-01',
                        'photos' => ['https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80']
                    ]
                ]
            ],
            [
                'name' => 'Al-Noor Grand Vista',
                'short_description' => 'Iconic Heritage Meets Modern Prestige in Dhanmondi Road 27 with Expansive Family Suites.',
                'description' => 'Al-Noor Grand Vista is Dhanmondi’s crown jewel for refined families seeking spacious layouts, lush green surroundings, and close proximity to premier schools and hospitals. Featuring large family living spaces, dedicated servant quarters with separate entry, landscaped terrace corridors, and a rooftop astronomical observation deck.',
                'category_name' => 'Signature Residential',
                'location_name' => 'Dhanmondi',
                'address' => 'Road 27 (Old) / 16 (New), Dhanmondi R/A, Dhaka',
                'status' => 'ongoing',
                'type' => 'residential',
                'land_area' => 12.00,
                'land_unit' => 'katha',
                'total_floors' => 14,
                'apartments_per_floor' => 2,
                'total_units' => 24,
                'price_from' => 36000000.00,
                'price_to' => 74000000.00,
                'price_label' => 'Starting from BDT 3.60 Crore',
                'progress_percentage' => 74,
                'launch_date' => '2024-06-15',
                'expected_completion' => '2026-11-30',
                'handover_date' => '2026-11-30',
                'is_featured' => true,
                'is_special_offer' => false,
                'is_published' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'brochure_pdf' => '#',
                'latitude' => 23.7530,
                'longitude' => 90.3765,
                'sort_order' => 3,
                'published_at' => now(),
                'amenities' => [
                    'Community Gathering Hall',
                    'Rooftop Walking & Jogging Track',
                    'Children’s Library & Study Corner',
                    'Solar Power Subsidized System',
                    'CCTV 24/7 Security Protection'
                ],
                'nearby_landmarks' => [
                    ['name' => 'Dhanmondi Lake Walkway', 'distance' => '2 mins'],
                    ['name' => 'Ibn Sina Hospital', 'distance' => '3 mins'],
                    ['name' => 'Mastermind School & Scholastica', 'distance' => '4 mins'],
                    ['name' => 'Rapa Plaza & Shimanto Square', 'distance' => '5 mins'],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Front Perspective of Al-Noor Grand Vista', 'type' => 'exterior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Luxury Living Space with Handcrafted Hardwood Trim', 'type' => 'interior'],
                ],
                'units' => [
                    [
                        'unit_type' => 'Vista Signature (Type A)',
                        'size_sqft' => 3200,
                        'bedrooms' => 4,
                        'bathrooms' => 4,
                        'balconies' => 3,
                        'parking_spaces' => 2,
                        'price' => 48000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 1
                    ],
                    [
                        'unit_type' => 'Vista Classic (Type B)',
                        'size_sqft' => 2450,
                        'bedrooms' => 3,
                        'bathrooms' => 3,
                        'balconies' => 3,
                        'parking_spaces' => 2,
                        'price' => 36000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 2
                    ],
                ],
                'construction_updates' => [
                    [
                        'title' => 'Internal Finishing, Tile Fixing and Painting in Progress',
                        'description' => 'Plaster work completed for all levels. Floor tile laying and sanitary piping pressure tests are currently progressing rapidly.',
                        'milestone' => 'finishing',
                        'progress_percentage' => 74,
                        'update_date' => '2026-09-20',
                        'photos' => ['https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80']
                    ]
                ]
            ],
            [
                'name' => 'Al-Noor Zenith Tower',
                'short_description' => 'Futuristic Elegance in Prime Bashundhara Block I with Curved Glass Terraces & Smart Home Systems.',
                'description' => 'Al-Noor Zenith Tower brings architectural panache to Bashundhara R/A. Crafted with aerodynamic curved cantilevered balconies, triple-height grand atrium, rooftop observatory deck, and fiber-optic smart building backbone for seamless ultra-fast automation.',
                'category_name' => 'Signature Residential',
                'location_name' => 'Bashundhara R/A',
                'address' => 'Plot 88, Road 14, Block I, Bashundhara R/A, Dhaka',
                'status' => 'upcoming',
                'type' => 'residential',
                'land_area' => 15.00,
                'land_unit' => 'katha',
                'total_floors' => 16,
                'apartments_per_floor' => 3,
                'total_units' => 45,
                'price_from' => 28500000.00,
                'price_to' => 62000000.00,
                'price_label' => 'Starting from BDT 2.85 Crore',
                'progress_percentage' => 12,
                'launch_date' => '2025-12-01',
                'expected_completion' => '2028-03-31',
                'handover_date' => '2028-03-31',
                'is_featured' => true,
                'is_special_offer' => false,
                'is_published' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1400&q=85',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'brochure_pdf' => '#',
                'latitude' => 23.8210,
                'longitude' => 90.4375,
                'sort_order' => 4,
                'published_at' => now(),
                'amenities' => [
                    'Gymnasium & Aerobics Studio',
                    'Executive Meeting Boardroom',
                    'Children\'s Game Zone & Daycare',
                    'Rooftop BBQ Pavilion',
                    'Automated Number Plate Recognition (ANPR) Parking'
                ],
                'nearby_landmarks' => [
                    ['name' => 'Evercare Hospital Dhaka', 'distance' => '5 mins'],
                    ['name' => 'North South University (NSU)', 'distance' => '4 mins'],
                    ['name' => 'Independent University Bangladesh (IUB)', 'distance' => '4 mins'],
                    ['name' => 'Jamuna Future Park', 'distance' => '8 mins'],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Al-Noor Zenith Tower Exterior Design', 'type' => 'exterior'],
                ],
                'units' => [
                    [
                        'unit_type' => 'Zenith Luxe (Type A)',
                        'size_sqft' => 2450,
                        'bedrooms' => 3,
                        'bathrooms' => 3,
                        'balconies' => 3,
                        'parking_spaces' => 2,
                        'price' => 32000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 1
                    ],
                ],
                'construction_updates' => [
                    [
                        'title' => 'Soil Investigation & Piling Rig Mobilization',
                        'description' => 'Rotary drilling piling rigs successfully positioned on site following comprehensive soil strata chemical and density analysis.',
                        'milestone' => 'foundation',
                        'progress_percentage' => 12,
                        'update_date' => '2026-08-10',
                        'photos' => ['https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=800&q=80']
                    ]
                ]
            ],
            [
                'name' => 'Al-Noor Imperial Heights',
                'short_description' => 'Ready to Move In Luxury Residences in Uttara Sector 4 next to Dhaka Metro Rail Station.',
                'description' => 'Al-Noor Imperial Heights is an impeccably crafted ready-to-move architectural statement in Uttara Sector 4, just 3 minutes away from the Metro Rail station. Completed with highest-grade materials, lush landscaping, fully operational elevators, and standby generators. Only 2 signature units remaining for immediate handover.',
                'category_name' => 'Signature Residential',
                'location_name' => 'Uttara',
                'address' => 'Sector 4, Road 18, Uttara Model Town, Dhaka',
                'status' => 'completed',
                'type' => 'residential',
                'land_area' => 10.00,
                'land_unit' => 'katha',
                'total_floors' => 12,
                'apartments_per_floor' => 2,
                'total_units' => 22,
                'price_from' => 27500000.00,
                'price_to' => 45000000.00,
                'price_label' => 'Starting from BDT 2.75 Crore (Ready)',
                'progress_percentage' => 100,
                'launch_date' => '2023-01-10',
                'expected_completion' => '2026-06-01',
                'handover_date' => '2026-06-01',
                'is_featured' => true,
                'is_special_offer' => false,
                'is_published' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=85',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'brochure_pdf' => '#',
                'latitude' => 23.8745,
                'longitude' => 90.3812,
                'sort_order' => 5,
                'published_at' => now(),
                'amenities' => [
                    'Equipped Rooftop Gym',
                    'CCTV 24/7 Security Guarding',
                    'Standby Generator 100% Load',
                    'Landscaped Rooftop Terrace',
                    'Driver Lounge & Waiting Room'
                ],
                'nearby_landmarks' => [
                    ['name' => 'Uttara Center Metro Rail Station', 'distance' => '3 mins'],
                    ['name' => 'Hazrat Shahjalal International Airport', 'distance' => '8 mins'],
                    ['name' => 'Uttara Club', 'distance' => '5 mins'],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Completed Front Façade - Imperial Heights', 'type' => 'exterior'],
                    ['image_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Finished Interior Living Room Ready for Move-In', 'type' => 'interior'],
                ],
                'units' => [
                    [
                        'unit_type' => 'Imperial Ready Suite',
                        'size_sqft' => 2450,
                        'bedrooms' => 3,
                        'bathrooms' => 3,
                        'balconies' => 3,
                        'parking_spaces' => 2,
                        'price' => 31000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 1
                    ]
                ],
                'construction_updates' => [
                    [
                        'title' => 'Project Successfully Completed & Handover In Progress',
                        'description' => 'RAJUK Occupancy Certificate issued. 90% of proud owners have received their keys.',
                        'milestone' => 'handover',
                        'progress_percentage' => 100,
                        'update_date' => '2026-06-01',
                        'photos' => ['https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80']
                    ]
                ]
            ],
            [
                'name' => 'Al-Noor Prime Nexus',
                'short_description' => 'Grade-A Corporate Headquarters in Gulshan 1 Avenue with LEED Platinum Certified Infrastructure.',
                'description' => 'Al-Noor Prime Nexus is Dhaka’s upcoming landmark commercial skyscraper. Designed for multinational corporations, fintech giants, and diplomatic consulates. Features LEED Platinum certified sustainable architectural envelope, smart destination-dispatch elevator banks, 4 basement parking levels, and high-security access lobbies.',
                'category_name' => 'Commercial Landmark',
                'location_name' => 'Gulshan 2',
                'address' => 'Gulshan Avenue, Gulshan 1/2 Hub, Dhaka',
                'status' => 'ongoing',
                'type' => 'commercial',
                'land_area' => 22.00,
                'land_unit' => 'katha',
                'total_floors' => 22,
                'apartments_per_floor' => 2,
                'total_units' => 40,
                'price_from' => 65000000.00,
                'price_to' => 280000000.00,
                'price_label' => 'Starting from BDT 6.50 Crore',
                'progress_percentage' => 30,
                'launch_date' => '2025-05-01',
                'expected_completion' => '2028-06-30',
                'handover_date' => '2028-06-30',
                'is_featured' => true,
                'is_special_offer' => false,
                'is_published' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=85',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'brochure_pdf' => '#',
                'latitude' => 23.7850,
                'longitude' => 90.4160,
                'sort_order' => 6,
                'published_at' => now(),
                'amenities' => [
                    'Corporate Sky Lounge & Bistro',
                    'Helipad on 22nd Rooftop Deck',
                    '120-Seat Conference Auditorium',
                    'Destination-Controlled High Speed Lifts',
                    'Central BMS & Automated Energy Optimization'
                ],
                'nearby_landmarks' => [
                    ['name' => 'Gulshan 1 Circle', 'distance' => '2 mins'],
                    ['name' => 'Westin Dhaka', 'distance' => '3 mins'],
                    ['name' => 'Hatirjheel Expressway Entry', 'distance' => '4 mins'],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=85', 'caption' => 'Prime Nexus Commercial Skyscraper Rendering', 'type' => 'exterior'],
                ],
                'units' => [
                    [
                        'unit_type' => 'Full Floor Corporate Suite',
                        'size_sqft' => 7500,
                        'bedrooms' => 0,
                        'bathrooms' => 6,
                        'balconies' => 2,
                        'parking_spaces' => 6,
                        'price' => 165000000,
                        'floor_plan_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80',
                        'is_available' => true,
                        'sort_order' => 1
                    ]
                ],
                'construction_updates' => [
                    [
                        'title' => 'Deep Substructure Excavation & Diaphragm Wall in Progress',
                        'description' => 'Hydromill diaphragm walling completed to 28m depth for 4-level deep basement construction.',
                        'milestone' => 'foundation',
                        'progress_percentage' => 30,
                        'update_date' => '2026-09-10',
                        'photos' => ['https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80']
                    ]
                ]
            ]
        ];

        foreach ($properties as $propData) {
            $category = $categoryModels[$propData['category_name']];
            $location = $locationModels[$propData['location_name']];

            $images = $propData['images'] ?? [];
            $units = $propData['units'] ?? [];
            $updates = $propData['construction_updates'] ?? [];

            unset($propData['category_name'], $propData['location_name'], $propData['images'], $propData['units'], $propData['construction_updates']);

            $propData['category_id'] = $category->id;
            $propData['location_id'] = $location->id;

            $property = Property::updateOrCreate(['name' => $propData['name']], $propData);

            // Images
            foreach ($images as $idx => $img) {
                PropertyImage::updateOrCreate(
                    ['property_id' => $property->id, 'image_path' => $img['image_path']],
                    [
                        'caption' => $img['caption'] ?? '',
                        'type' => $img['type'] ?? 'exterior',
                        'sort_order' => $idx + 1,
                    ]
                );
            }

            // Units
            foreach ($units as $u) {
                PropertyUnit::updateOrCreate(
                    ['property_id' => $property->id, 'unit_type' => $u['unit_type']],
                    $u
                );
            }

            // Construction updates
            foreach ($updates as $up) {
                ConstructionUpdate::updateOrCreate(
                    ['property_id' => $property->id, 'title' => $up['title']],
                    $up
                );
            }
        }

        // 5. Hero Sliders
        $sliders = [
            [
                'title' => 'Architectural Landmarks Redefining Dhaka’s Skyline',
                'subtitle' => 'Pioneering ultra-luxury residences, sky duplexes and bespoke commercial estates with uncompromising craftsmanship.',
                'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1920&q=90',
                'cta_text' => 'Explore Signature Projects',
                'cta_link' => '/properties',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Banani Lakefront Horizons: Tranquility Reimagined',
                'subtitle' => 'Unobstructed water vistas, cantilevered sky gardens, and double-height infinity living in Dhaka’s premier neighborhood.',
                'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1920&q=90',
                'cta_text' => 'View Lakefront Mirage',
                'cta_link' => '/properties/al-noor-lakefront-mirage',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Empowering Landowners Through High-Yield Joint Ventures',
                'subtitle' => 'Unlock maximum property valuation, world-class architectural design, and guaranteed on-time handover with Al-Noor.',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=90',
                'cta_text' => 'Partner With Us',
                'cta_link' => '/landowners',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slide) {
            Slider::updateOrCreate(['title' => $slide['title']], $slide);
        }

        // 6. Blog Posts
        $blogs = [
            [
                'title' => 'Why Real Estate in Gulshan & Banani Continues to Outperform Capital Markets in 2026',
                'excerpt' => 'An in-depth market analysis on luxury housing demand, infrastructure appreciation, and capital yield in Dhaka’s most coveted diplomatic enclaves.',
                'content' => '<p>Dhaka’s luxury real estate sector has demonstrated resilient capital appreciation despite global economic fluctuations. Prime districts such as Gulshan 2, Banani, and Dhanmondi have consistently yielded 12-16% annual property value gains.</p><p>High-net-worth buyers prioritize earthquake safety (BNBC 2020), green building ratings, reliable power redundancy, and trusted track records of handover delivery.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1000&q=80',
                'category' => 'Market Insights',
                'author' => 'Engr. Tariqul Islam',
                'tags' => ['Real Estate', 'Gulshan', 'Investment', 'Dhaka'],
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'The Evolution of Biophilic Architecture & Green Building in Bangladesh',
                'excerpt' => 'How integrating vertical gardens, cross-ventilation, and rainwater harvesting is transforming living wellness across modern Dhaka apartments.',
                'content' => '<p>Biophilic design is not merely an aesthetic trend; it is essential to long-term health and sustainability. Al-Noor Properties integrates cascading terrace greenery and thermal acoustic glass to lower energy consumption by up to 35%.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80',
                'category' => 'Architecture & Design',
                'author' => 'Ar. Sabrina Chowdhury',
                'tags' => ['Green Architecture', 'Sustainability', 'Living Wellness'],
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Landowner Joint Venture Guide: Maximizing Returns & Securing Your Heritage',
                'excerpt' => 'Key legal, architectural, and financial considerations every Dhaka landowner should evaluate before entering a joint development agreement.',
                'content' => '<p>Joint venture partnerships represent the gold standard for landowners seeking to unlock exponential financial value without dealing with construction hassles. Learn about ratio splits, signing bonuses, and structural warranties.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1000&q=80',
                'category' => 'Landowner Guide',
                'author' => 'Adv. Mahfuzur Rahman',
                'tags' => ['Landowners', 'Joint Venture', 'Legal Guide'],
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($blogs as $b) {
            BlogPost::updateOrCreate(['title' => $b['title']], $b);
        }

        // 7. Testimonials
        $testimonials = [
            [
                'client_name' => 'Barrister Anisul Haque & Dr. Farzana Haque',
                'client_designation' => 'Homeowners, Al-Noor Crown Palace',
                'project_name' => 'Al-Noor Crown Palace, Gulshan',
                'client_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'quote' => 'Al-Noor Properties delivers what few developers in Bangladesh can: meticulous attention to structural integrity, transparent milestone tracking, and aesthetic grace that rivals world-class luxury residences in Singapore or Dubai.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'client_name' => 'Syed Nazmul Hasan',
                'client_designation' => 'Landowner Partner, Banani Road 11',
                'project_name' => 'Al-Noor Lakefront Mirage',
                'client_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
                'quote' => 'Entrusting our ancestral land to Al-Noor was the finest decision our family made. Their joint-venture terms were exceptionally fair, legal due-diligence was seamless, and construction progress has been ahead of schedule.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'client_name' => 'Rubaba Dowla',
                'client_designation' => 'Executive Director, Global Tech Holdings',
                'project_name' => 'Al-Noor Grand Vista, Dhanmondi',
                'client_photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
                'quote' => 'From the expansive ceiling heights to the silent acoustic glass and prompt customer support, living at an Al-Noor property is an absolute joy. A truly world-class developer in Dhaka.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }

        // 8. Team Members
        $team = [
            [
                'name' => 'Al-Haj Noor Mohammed',
                'designation' => 'Founder & Chairman of the Board',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80',
                'bio' => 'A visionary pioneer with over 30 years of excellence in infrastructure, construction, and nation-building initiatives across Bangladesh.',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Engr. Kazi Shamsul Alam',
                'designation' => 'Managing Director & CEO',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80',
                'bio' => 'BUET Civil Engineering alumnus with 22+ years leading mega real estate developments, high-rise structural engineering, and corporate excellence.',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Ar. Sabrina Chowdhury',
                'designation' => 'Chief Architectural Officer',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Master of Architecture from National University of Singapore (NUS), specializing in sustainable luxury condominiums and biophilic building envelopes.',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Rashidul Karim, CFA',
                'designation' => 'Chief Financial Officer',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Expert in capital structuring, project financing, and landowner joint-venture wealth optimization models.',
                'is_active' => true,
                'sort_order' => 4
            ],
        ];

        foreach ($team as $tm) {
            TeamMember::updateOrCreate(['name' => $tm['name']], $tm);
        }

        // 9. Site Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Al-Noor Properties BD', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'Crafting Architectural Landmarks & Dhaka’s Finest Living Spaces', 'group' => 'general'],
            ['key' => 'phone_primary', 'value' => '+880 1894-916600', 'group' => 'contact'],
            ['key' => 'phone_hotline', 'value' => '16688', 'group' => 'contact'],
            ['key' => 'email_primary', 'value' => 'info@alnoorpropertiesbd.com', 'group' => 'contact'],
            ['key' => 'email_sales', 'value' => 'sales@alnoorpropertiesbd.com', 'group' => 'contact'],
            ['key' => 'corporate_address', 'value' => 'Al-Noor Tower, Level 12-14, Plot 88, Road 11, Block D, Banani, Dhaka-1213, Bangladesh', 'group' => 'contact'],
            ['key' => 'stat_completed_sqft', 'value' => '3.5 Million+ Sq. Ft. Delivered', 'group' => 'stats'],
            ['key' => 'stat_happy_families', 'value' => '1,200+ Discerning Families', 'group' => 'stats'],
            ['key' => 'stat_on_time_ratio', 'value' => '99.4% On-Time Handover Record', 'group' => 'stats'],
            ['key' => 'stat_years_experience', 'value' => '25+ Years of Trust & Legacy', 'group' => 'stats'],
            ['key' => 'whatsapp_number', 'value' => '+8801894916600', 'group' => 'social'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/alnoorpropertiesbd', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/alnoorpropertiesbd', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@alnoorpropertiesbd', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/alnoorpropertiesbd', 'group' => 'social'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
