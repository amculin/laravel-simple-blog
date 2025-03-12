<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            'author_id' => 1,
            'title' => 'Exclusive: Meta begins testing its first in-house AI training chip',
            'slug' => 'meta-begins-testing-its-first-in-house-ai-training-chip',
            'content' => "NEW YORK, March 11 (Reuters) - Facebook owner Meta (META.O), opens new tab is testing
                its first in-house chip for training artificial intelligence systems, a key milestone as it moves
                to design more of its own custom silicon and reduce reliance on external suppliers like Nvidia (NVDA.O),
                opens new tab, two sources told Reuters. The world's biggest social media company has begun a small
                deployment of the chip and plans to ramp up production for wide-scale use if the test goes well,
                the sources said.",
            'status' => 1,
            'publish_at' => '2025-03-11 20:37:00',
            'created_at' => '2025-03-11 20:37:00'
        ]);

        DB::table('articles')->insert([
            'author_id' => 1,
            'title' => 'Apple launches new iPad Air with AI features to stoke demand',
            'slug' => 'apple-launches-new-ipad-air-with-ai-features-stoke-demand',
            'content' => "March 4 (Reuters) - Apple (AAPL.O), opens new tab on Tuesday launched new versions of its
                iPad Air, enhancing the mid-tier tablet with its M3 chip and artificial intelligence capabilities
                in a bid to spur upgrades among customers. The revamped lineup starts at $599 for the 11-inch model,
                and the 13-inch variant at $799. Pre-orders open Tuesday, with deliveries set to start on March 12.",
            'status' => 1,
            'publish_at' => '2025-03-11 20:38:00',
            'created_at' => '2025-03-11 20:38:00'
        ]);

        DB::table('articles')->insert([
            'author_id' => 2,
            'title' => 'The Ride-Sharing and Robotaxi Revenue Model Problem No One Talks About',
            'slug' => 'the-ride-sharing-and-robotaxi-revenue-model-problem-no-one-talks-about',
            'content' => "Robotaxi services are spreading broadly. While they’ve clearly had issues in San Francisco —
                as have I, driving in San Francisco — those challenges are improving. Now, both Uber and Lyft appear to
                be taking steps toward replacing their ride-share drivers with AI.
                
                We may be on the verge of one of the first large-scale AI job replacement efforts that everyone will
                witness. This transition will fix a key issue with ride-sharing by aligning revenue more directly with
                its users. However, it won’t address a deeper problem that ride-sharing has in common with social media:
                a decoupled revenue business model — where the people using a service aren’t necessarily funding it.",
            'status' => 3,
            'created_at' => '2025-03-11 20:37:00'
        ]);

        DB::table('articles')->insert([
            'author_id' => 2,
            'title' => 'Amazon Moves To Make Alexa Smart',
            'slug' => 'amazon-moves-to-make-alexa-smart',
            'content' => "When we started with digital assistants, Microsoft potentially had the inside track. Its Cortana
                effort was named after the Halo AI character, which gave it far more potential than the others.
                
                Apple had a decent shot, too. It marketed Siri very well but didn’t seem to want to fund its advancement,
                while Amazon just shipped product after product that used Alexa.
                
                Google was no slouch either, pivoting hard to its Gemini product (which I use a lot) for Pixel smartphones.
                
                What I find fascinating is that Panos Panay, the guy who pretty much made the Microsoft Surface line a thing
                and drove my favorite phone, the Surface Duo, is now at Amazon and apparently doing there what should have
                happened at Microsoft with Cortana.",
            'status' => 2,
            'publish_at' => '2025-03-14 10:27:00',
            'created_at' => '2025-03-11 20:47:00'
        ]);

        DB::table('articles')->insert([
            'author_id' => 3,
            'title' => 'Preventing Critical Server Security Issues With Linux Live Patching',
            'slug' => 'preventing-critical-server-security-issues-with-linux-live-patching',
            'content' => "Enterprise Linux users face growing risks from software vulnerabilities, especially given their
                widespread reliance on open-source code in Linux applications and commercial software.
                
                Live kernel patching minimizes the need for organizations to take down servers, reboot systems, or schedule
                disruptive maintenance windows. While these challenges are significant, live patching offers a practical
                solution to reduce downtime and improve operational efficiency.
                
                Besides applying kernel patches, keeping up with security patches of known and newly discovered software
                vulnerabilities is a worsening problem for all computing platforms. The process is critical with the heavy
                integration of open-source code used in both Linux applications and commercial software.",
            'status' => 1,
            'publish_at' => '2025-03-11 20:49:00',
            'created_at' => '2025-03-11 20:49:00'
        ]);
    }
}
