<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| MICE
| -------------------------------------------------------------------
| This file contains an array of mice arranged by treasure map locations
|
*/

$config['treasure_maps'] = array(
		'lg' 		=> array('Bark', 'Calalilly', 'Camoflower', 'Shroom', 'Strawberry Hotcakes', 'Thirsty', 'Thistle', 'Carmine the Apothecary', 'Cursed', 'Essence Collector', 'Ethereal Enchanter', 'Ethereal Engineer', 'Ethereal Librarian', 'Ethereal Thief', 'Dunehopper', 'Grubling', 'Grubling Herder', 'Quesodillo', 'Sand Pilgrim', 'Spiky Devil', 'Barkshell', 'Camofusion', 'Dehydrated', 'Fungal Spore', 'Thorn', 'Twisted Hotcakes', 'Twisted Lilly', 'Twisted Carmine', 'Corrupt', 'Cursed Enchanter', 'Cursed Engineer', 'Cursed Librarian', 'Cursed Thief', 'Essence Guardian', 'King Grub', 'Sand Colossus', 'Sarcophamouse', 'Scarab', 'Serpentine'),
		'sunken'	=> array("Carnivore","Derpshark","Coral Dragon","Coral Gardener","Coral Guard","Coral Queen","Turret Guard","Coral Harvester","Coral","Coral Cuddler","Seadragon","Eel","Jellyfish","City Noble","Sunken Citizen","Clumsy Carrier","Elite Guardian","Enginseer","Oxygen Baron","City Worker","Hydrologist","Barracuda","Clownfish","Spear Fisher","Deep Sea Diver","Deranged Deckhand","Pirate Anchor","Sunken Banshee","Swashblade","Ancient of the Deep","Tritus","Angler","Mershark","Octomermaid","Old One","Urchin King","Treasure Keeper","Mermousette","Serpent Monster","Betta","Koimaid","Angelfish","Stingray","Pearl Diver","Sand Dollar Queen","Barnacle Beautician","Bottom Feeder","Crabolia","Saltwater Axolotl","Sand Dollar Diver","Guppy","School of Mish","Tadpole","Cuttle","Manatee","Mlounder Flounder","Puffer","Dread Pirate Mousert","Pearl","Treasure Hoarder"),
		'rift'		=> array(
				// grift
				"Brawny","Greyrun","Riftweaver","Agitated Gentle Giant","Excitable Electric","Supernatural","Dream Drifter","Micro","Mighty Mole","Cyborg","Raw Diamond","Rift Guardian","Shard Centurion","Spiritual Steel","Wealth","Goliath Field",
				// brift
				"Amplified White","Automated Sentry","Evil Scientist","Rift Bio Engineer","Amplified Brown","Amplified Grey","Cybernetic Specialist","Doktor","Portable Generator","Surgeon Bot","Count Vampire","Phase Zombie","Prototype","Robat","Tech Ravenous Zombie","Mecha Tail","Radioactive Ooze","Toxikinetic","Clump","Cyber Miner","Itty Bitty Rifty Burroughs","Pneumatic Dirt Displacement","Rifterranian","Monstrous Abomination","Assassin Beast","Plutonium Tentacle","The Menace of the Rift","Big Bad Behemoth Burroughs","Lycanoid","Revenant","Zombot Unipire the Third","Rancid Bog Beast","Super Mega Mecha Ultra RoboGold","Toxic Avenger","Boulder Biter","Lambent","Master Exploder",
				// wrift
				"Monstrous Black Widow","Cherry Sprite","Grizzled Silth","Naturalist","Bloomed Sylvan","Cranky Caterpillar","Crazed Goblin","Fungal Frog","Gilded Leaf","Karmachameleon","Mossy Moosker","Spirit of Balance","Twisted Treant","Water Sprite","Treant Queen","Spirit Fox","Red-Eyed Watcher Owl","Medicine","Tree Troll","Winged Harpy","Red Coat Bear","Rift Tiger","Nomadic Warrior","Cyclops Barbarian","Tri-dra","Centaur Ranger"
		),
		'fungal'	=> array("Crystal Behemoth","Diamondhide","Huntereater","Crystal Golem","Crystal Lurker","Crystal Observer","Crystal Queen","Cavern Crumbler","Crag Elder","Crystalline Slasher","Dirt Thing","Gemstone Worshipper","Shattered Obsidian","Splintered Stone Sentry","Stone Maiden","Crystal Cave Worm","Crystal Controller","Crystalback","Gemorpher","Stalagmite","Bitter Root","Floating Spore","Funglore","Lumahead","Mouldy Mole","Mush","Mushroom Sprite","Quillback","Spiked Burrower","Spore Muncher","Sporeticus","Nightshade Masquerade"),
		'gauntlet'	=> array(
				//other areas
				"Nibbler","Gold","Diamond","Longtail","Magic","Pugilist","Scruffy","Tiny","Flying","Speedy","Burglar","Black Widow",
				
				//gauntlet
				"Clockwork Samurai","Hapless Marionette","Puppet Master","Sock Puppet Ghost","Toy Sylvan","Wound Up White","Bandit","Escape Artist","Impersonator","Lockpick","Rogue","Stealth","Berserker","Cavalier","Fencer","Knight","Page","Phalanx","Cowbell","Dancer","Drummer","Fiddler","Guqin Player","Aquos","Black Mage","Ignis","Terra","Zephyr","Paladin","Sacred Shrine","White Mage","Fiend","Necromancer","Eclipse"
		),
		'shelder'	=> array(
				//Balack's Cove
				"Davy Jones","Tidal Fisher","Twisted Fiend","Brimstone","Enslaved Spirit","Riptide",
				
				
				//Jungle of Dread
				"Swarm of Pygmy Mice","Pygmy Wrangler",
				
				//derr
				"Trailblazer","Wordsmith","Healer","Grunt","Spellbinder","Mintaka","Seer","Renegade",
				
				//nerg
				"Narrator", "Pathfinder","Caretaker","Finder","Beast Tamer","Alnilam","Conjurer",
				
				//elub
				"Alchemist","Scout","Taleweaver","Alnitak","Mystic","Soothsayer","Vanquisher","Pack",
				
				//ss huntington III
				"Briegull","Salt Water Snapper","Buccaneer","Pinchy","Shipwrecked","Siren","Water Nymph","Captain","Bottled","Swabbie","Mermouse","Cook","Shelder"
		),
		'acolyte'	=> array(
				// acolyte realm
				"Spectre", "Gorgon","Gate Guardian","Sorcerer","Golem","Lich","Wight","Acolyte",
				
				// mousoleum
				"Lycan",
				
				//catacombs
				"Ooze","Skeleton","Spider","Keeper","Keeper's Assistant","Scavenger","Terror Knight","Vampire",
				
				// forbidden grove
				"Realm Ripper"
		)
);


$config['maps_riftmice'] = array(
	"grift" => array(
		'Marble String' 	=> array("Brawny","Greyrun","Riftweaver"),
		'Brie String'		=> array("Agitated Gentle Giant","Excitable Electric","Supernatural"),
		'Magical String'	=> array("Dream Drifter","Micro","Mighty Mole"),
		'Riftiago'			=> array("Cyborg","Raw Diamond","Rift Guardian","Shard Centurion","Spiritual Steel","Wealth"),
		'Resonator'			=> array("Goliath Field")
	),
	"brift" => array(
			"(Mist Lvl 0) Brie String" 				=> array("Amplified White","Automated Sentry","Evil Scientist","Rift Bio Engineer"),
			"(Mist Lvl 0) Magical String" 			=> array("Amplified Brown","Amplified Grey","Cybernetic Specialist","Doktor","Portable Generator","Surgeon Bot"),
			"(Mist Lvl 1-5) Magical/Brie String" 	=> array("Count Vampire","Phase Zombie","Prototype","Robat","Tech Ravenous Zombie"),
			"(Mist Lvl 1-5) Terre Ricotta" 			=> array("Clump","Cyber Miner","Itty Bitty Rifty Burroughs","Pneumatic Dirt Displacement","Rifterranian"),
			"(Mist Lvl 1-5) Polluted Parmesan" 		=> array("Mecha Tail","Radioactive Ooze","Toxikinetic"),
			"(Mist Lvl 6-18) Magical/Brie String" 	=> array("Lycanoid","Revenant","Zombot Unipire the Third"),
			"(Mist Lvl 6-18) Terre Ricotta" 		=> array("Boulder Biter","Lambent","Master Exploder"),
			"(Mist Lvl 6-18) Polluted Parmesan" 	=> array("Rancid Bog Beast","Super Mega Mecha Ultra RoboGold","Toxic Avenger"),
			"(Mist Lvl 19-20) Magical/Brie String" 	=> array("Monstrous Abomination"),
			"(Mist Lvl 19-20) Terre Ricotta" 		=> array("Big Bad Behemoth Burroughs"),
			"(Mist Lvl 19-20) Polluted Parmesan" 	=> array("Assassin Beast","Plutonium Tentacle","The Menace of the Rift")
	),
	"wrift" => array(
			"(All Rage 25+) Lactrodectus Lancashire"				=> array("Monstrous Black Widow"),
			"(Crazed Clearing) Magical String with Cherry"			=> array("Cherry Sprite"),
			"(Deep Lagoon) Magical String with Stagnant"			=> array("Grizzled Silth"),
			"(Gigantic Gnarled Tree) Magical String with Gnarled"	=> array("Naturalist"),
			"(Rage 0-24) Magical String"							=> array("Bloomed Sylvan","Cranky Caterpillar","Crazed Goblin","Fungal Frog","Gilded Leaf","Karmachameleon","Mossy Moosker","Spirit of Balance","Twisted Treant","Water Sprite"),
			"(Rage 25+ CC) Magical String"							=> array("Treant Queen","Spirit Fox","Red-Eyed Watcher Owl"),
			"(Rage 25+ DL) Magical String"							=> array("Medicine","Tree Troll","Winged Harpy"),
			"(Rage 25+ GGT) Magical String"							=> array("Red Coat Bear","Rift Tiger","Nomadic Warrior"),
			"(Rage 50 CC) Magical String"							=> array("Cyclops Barbarian"),
			"(Rage 50 DL) Magical String"							=> array("Tri-dra"),
			"(Rage 50 GGT) Magical String"							=> array("Centaur Ranger")
	),
);

$config['maps_lgmice'] = array(
	// TODO: poured, cursed, salted states
	'Living Garden/regular' 		=> array('Bark', 'Calalilly', 'Camoflower', 'Shroom', 'Strawberry Hotcakes', 'Thirsty', 'Thistle'),
	'Living Garden/duskshade' 		=> array('Carmine the Apothecary'),
	'Lost City/dewthief' 			=> array('Cursed', 'Essence Collector', 'Ethereal Enchanter', 'Ethereal Engineer', 'Ethereal Librarian', 'Ethereal Thief'),
	'Sand Dunes/dewthief' 			=> array('Dunehopper', 'Grubling', 'Grubling Herder', 'Quesodillo', 'Sand Pilgrim', 'Spiky Devil'),
	'Twisted Garden/duskshade' 		=> array('Barkshell', 'Camofusion', 'Dehydrated', 'Fungal Spore', 'Thorn', 'Twisted Hotcakes', 'Twisted Lilly'),
	'Twisted Garden/lunaria' 		=> array('Twisted Carmine'),
	'Cursed City/graveblossom' 		=> array('Corrupt', 'Cursed Enchanter', 'Cursed Engineer', 'Cursed Librarian', 'Cursed Thief', 'Essence Guardian'),
	'Sand Crypts/graveblossom' 		=> array('King Grub', 'Sand Colossus', 'Sarcophamouse', 'Scarab', 'Serpentine')
);

$config['maps_sunkenmice'] = array(
		'Docked (Regular non-SB+)'	=> array("City Noble", "City Worker", "Sunken Citizen"),
		'Docked (Fishy Fromage)'	=> array("City Noble", "City Worker", "Clumsy Carrier","Elite Guardian", "Enginseer", "Hydrologist", "Oxygen Baron", "Sunken Citizen"),
		'Docked (SB+)'				=> array("Hydrologist"),
		
		'Carnivore Cove'		=> array("Carnivore", "Derpshark", "Serpent Monster", "Spear Fisher"),
		'Coral Castle'			=> array("Angelfish", "Coral Dragon", "Coral Gardener", "Coral Guard", "Coral Queen", "Turret Guard"),
		'Coral Garden'			=> array("Coral", "Coral Dragon", "Coral Gardener", "Coral Harvester", "Jellyfish", "Seadragon"),
		'Coral Reef'			=> array("Clownfish", "Coral", "Coral Cuddler", "Cuttle", "Mlounder Flounder", "Seadragon"),
		'Deep Oxygen Stream'	=> array("Angelfish", "Betta", "Eel", "Jellyfish", "Koimaid", "Stingray"),
		'Feeding Grounds'		=> array("Barracuda", "Clownfish", "Derpshark", "Spear Fisher"),
		'Haunted Shipwreck'		=> array("Deep Sea Diver", "Deranged Deckhand", "Eel", "Pirate Anchor","Sunken Banshee", "Swashblade"),
		'Lair of the Ancients'	=> array("Ancient of the Deep", "Tritus"),
		'Lost Ruins'			=> array("Angler", "Betta", "Mershark", "Octomermaid", "Old One", "Urchin King"),
		'Magma Flow'			=> array("Angelfish", "Betta", "Eel", "Serpent Monster", "Treasure Hoarder", "Treasure Keeper"),
		'Mermouse Den'			=> array("Guppy", "Koimaid", "Mermousette", "Mershark", "Octomermaid", "Tadpole"),
		'Monster Trench'		=> array("Ancient of the Deep", "Carnivore", "Serpent Monster", "Tritus"),
		'Murky Depths'			=> array("Angelfish", "Betta", "Eel", "Jellyfish", "Koimaid", "Stingray"),
		'Oxygen Stream'			=> array("Cuttle", "Jellyfish", "Koimaid", "Manatee", "Puffer", "Stingray"),
		'Pearl Patch'			=> array("Pearl", "Pearl Diver", "Saltwater Axolotl", "Sand Dollar Queen"),
		'Rocky Outcrop'			=> array("Barnacle Beautician", "Bottom Feeder", "Crabolia", "Manatee", "Mlounder Flounder"),
		'Sand Dollar Sea Bar'	=> array("Mlounder Flounder", "Saltwater Axolotl","Sand Dollar Diver", "Sand Dollar Queen"),
		'School of Mice'		=> array("Clownfish", "Guppy", "Mlounder Flounder", "Puffer", "School of Mish", "Tadpole"),
		'Sea Floor'				=> array("Cuttle", "Jellyfish", "Koimaid", "Manatee", "Puffer", "Stingray"),
		'Shallow Shoals'		=> array("Clownfish", "Cuttle", "Manatee", "Mlounder Flounder", "Puffer"),
		'Shipwreck'				=> array("Barnacle Beautician", "Crabolia", "Deep Sea Diver", "Dread Pirate Mousert", "Pirate Anchor", "Stingray"),
		'Sunken Treasure'		=> array("Pearl", "Pearl Diver", "Treasure Hoarder", "Treasure Keeper")
);

$config['maps_fungalmice'] = array(
		'Diamond'				=> array("Crystal Behemoth","Diamondhide","Huntereater"),
		'Gemstone'				=> array("Crystal Golem","Crystal Lurker","Crystal Observer","Crystal Queen"),
		'Glowing Gruyere'		=> array("Cavern Crumbler","Crag Elder","Crystalline Slasher","Dirt Thing","Gemstone Worshipper","Shattered Obsidian","Splintered Stone Sentry","Stone Maiden"),
		'Mineral'				=> array("Crystal Cave Worm","Crystal Controller","Crystalback","Gemorpher","Stalagmite"),
		'Regular non-SB+'		=> array("Bitter Root","Floating Spore","Funglore","Lumahead","Mouldy Mole","Mush","Mushroom Sprite","Quillback","Spiked Burrower","Spore Muncher","Sporeticus"),
		'SB+'					=> array("Nightshade Masquerade") 
);

$config['maps_gauntletmice'] = array(
		'Town of Gnawnia/SB+'		=> array("Nibbler"),
		'Harbour/SB+'				=> array("Magic"),
		'Mountain/SB+'				=> array("Black Widow"),
		'Mountain/White Cheddar'	=> array("Gold","Diamond"),
		'King\'s Arms/Gilder'		=> array("Burglar"),
		'King\'s Arms/White Cheddar'=> array("Longtail","Scruffy"),
		'Windmill/SB+'				=> array("Speedy"),
		'Windmill/White Cheddar'	=> array("Pugilist"),
		'Meadow/SB+'				=> array("Tiny","Flying"),
		"King's Gauntlet/Regular"	=> array("Clockwork Samurai","Hapless Marionette","Puppet Master","Sock Puppet Ghost","Toy Sylvan","Wound Up White"),
		'Tier 2'					=> array("Bandit","Escape Artist","Impersonator","Lockpick","Rogue","Stealth"),
		'Tier 3'					=> array("Berserker","Cavalier","Fencer","Knight","Page","Phalanx"),
		'Tier 4'					=> array("Cowbell","Dancer","Drummer","Fiddler","Guqin Player"),
		'Tier 5'					=> array("Aquos","Black Mage","Ignis","Terra","Zephyr"),
		'Tier 6'					=> array("Paladin","Sacred Shrine","White Mage"),
		'Tier 7'					=> array("Fiend","Necromancer"),
		'Tier 8'					=> array("Eclipse")
);

$config['maps_sheldermice'] = array(
		"Balack's Cove/Vengeful"	=> array("Davy Jones","Tidal Fisher","Twisted Fiend","Brimstone","Enslaved Spirit","Riptide"),
		"Jungle of Dread"			=> array("Swarm of Pygmy Mice","Pygmy Wrangler"),
		"Derr Dunes"				=> array("Grunt","Spellbinder","Mintaka","Seer","Renegade","Trailblazer","Wordsmith","Healer"),
		"Nerg Planes"				=> array("Finder","Beast Tamer","Alnilam","Conjurer","Narrator","Pathfinder","Caretaker"),
		"Elub Shore"				=> array("Alnitak","Mystic","Soothsayer","Vanquisher","Pack","Alchemist","Scout","Taleweaver"),
		"SS Huntington"				=> array("Briegull","Salt Water Snapper","Buccaneer","Pinchy","Shipwrecked","Siren","Water Nymph","Captain","Bottled","Swabbie","Mermouse","Shelder"),
		"SS Huntington/SB+"			=> array("Cook"),
		"Cape Clawed/Shell"			=> array("Alchemist","Scout","Taleweaver"),
		"Cape Clawed/Gumbo"			=> array("Narrator","Pathfinder","Caretaker"),
		"Cape Clawed/Crunchy"		=> array("Trailblazer","Wordsmith","Healer")
);

$config['maps_acolytemice'] = array(
		"Acolyte Realm/Runic"		=> array("Lich","Wight","Acolyte"),
		"Acolyte Realm/Ancient"		=> array("Spectre", "Gorgon","Sorcerer"),
		"Acolyte Realm/RB"			=> array("Gate Guardian","Golem"),
		
		"Mousoleum/Moon"			=> array("Lycan"),
		"Catacombs/Ancient"			=> array("Ooze","Skeleton","Spider","Keeper","Keeper's Assistant","Scavenger","Terror Knight","Vampire"),
		"Catacombs/Undead"			=> array("Vampire"),
		
		"Forbidden Grove/Moon"		=> array("Scavenger"),
		"Forbidden Grove/Ancient"	=> array("Scavenger","Spider"),
		"Forbidden Grove/RB"		=> array("Realm Ripper")
);


/* End of file mice.php */
/* Location: ./application/config/mice.php */