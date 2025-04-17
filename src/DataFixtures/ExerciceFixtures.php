<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Service\ExerciseApiService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(lazy: true)]
class ExerciceFixtures extends Fixture
{
    private ExerciseApiService $exerciseApiService;

    public function __construct(ExerciseApiService $exerciseApiService)
    {
        $this->exerciseApiService = $exerciseApiService;
    }

    public function load(ObjectManager $manager): void
    {
        try {
            $apiExercises = $this->exerciseApiService->getAllExercises();
            $typeKeywords = $this->getExerciseTypeKeywords();
            $i = 0;
            foreach ($apiExercises as $apiExercise) {
                $i++;
                $exerciseName = $apiExercise['name'];
                $exerciseType = $this->inferExerciseType($exerciseName, $typeKeywords);

                $exercice = new Exercice();
                $exercice->setNom($exerciseName);
                $exercice->setReps(rand(5, 15));
                $exercice->setImageUrl($apiExercise['gifUrl'] ?? 'https://via.placeholder.com/150');
                $exercice->setSets(rand(1, 5));
                $exercice->setDureeMinutes(rand(5, 20));
                $exercice->setTypeExercice($exerciseType);
                $manager->persist($exercice);
                if($i > 30){
                    break;
                }
            }

            $manager->flush();

        } catch (\Throwable $e) {
            error_log('Error fetching and loading exercises from API: ' . $e->getMessage());
        }
    }

    private function getExerciseTypeKeywords(): array
    {
        return [
            'MUSCULATION' => [
                'sit-up', 'bend', 'pulldown', 'dip', 'raise', 'pull-up', 'press', 'row', 'curl', 'deadlift', 'fly', 'extension', 'shrug', 'squat', 'pullover', 'snatch', 'lunge', 'rollerout', 'twist', 'grip', 'hammer', 'preacher', 'skullcrusher', 'military', 'bradford', 'jefferson', 'jm', 'jump', 'lying', 'narrow', 'one arm', 'overhead', 'prone', 'rack', 'rear delt', 'reverse wrist', 'reverse curl', 'romanian', 'seated', 'side bent', 'split', 'single leg', 'speed', 'standing', 'step-up', 'stiff leg', 'sumo', 'upright', 'wide', 'wrist curl', 'zercher', 'alternate', 'assisted', 'barbell', 'cable', 'dumbbell', 'ez barbell', 'olympic barbell', 'smith', 'lever', 'machine', 'weighted', 'close-grip', 'decline', 'incline', 'front', 'back', 'lateral', 'concentration', 'cross-over', 'bent over', 'good morning', 'guillotine', 'hack', 'inner', 'outer', 'palm', 'pronation', 'supination', 'tate', 'w-press', 'zottman', 'anti gravity', 'spider', 'finger', 'flexion', 'floor', 'gironda', 'gorilla', 'groin', 'handstand', 'hanging', 'hip', 'hyperextension', 'inverse', 'isometric', 'jackknife', 'janda', 'kettlebell', 'landmine', 'leg pull in', 'london bridge', 'march sit', 'monster walk', 'muscle up', 'negative', 'oblique', 'otis', 'outside leg kick', 'power clean', 'pull-in', 'push-up', 'raise single arm', 'rear decline bridge', 'rear pull-up', 'reverse dip', 'reverse grip', 'ring', 'rocky', 'scapular', 'self assisted', 'shoulder tap', 'side bridge', 'side hip', 'side push', 'side-to-side', 'single arm', 'sled', 'spell caster', 'spider crawl', 'squat jerk', 'stork stance', 'suspended', 'trap bar', 'triceps', 'twin handle', 'vertical', 'walking lunge', 'butt-ups', 'tuck', 'band', 'modified', 'plyo', 'scott', 'goblet', 'clean', 'jerk', 'windmill', 'thruster', 'turkish get up', 'rowing', 'skiiing', 'elliptical', 'stairmaster', 'rower', 'climber', 'lateral step-up', 'box jump', 'skater jumps',
            ],
            'CARDIO' => [
                'air bike', 'balance board', 'battling ropes', 'burpee', 'circles knee stretch', 'clock push-up', 'cross body crunch', 'dead bug', 'flutter kicks', 'front plank with twist', 'inchworm', 'jack burpee', 'jackknife sit-up', 'kick out sit', 'kipping muscle up', 'march sit', 'monster walk', 'mountain climber', 'one arm slam', 'otis up', 'pull-in', 'run', 'russian twist', 'side bridge', 'side plank', 'single leg platform slide', 'sit-up', 'spell caster', 'spider crawl', 'standing wheel rollerout', 'stationary bike walk', 'superman push-up', 'suspended abdominal fallout', 'suspended reverse crunch', 'tuck crunch', 'reverse crunch', 'band alternating v-up', 'band bicycle crunch', 'band jack knife sit-up', 'band kneeling twisting crunch', 'band pull through', 'band push sit-up', 'band standing crunch', 'band standing twisting crunch', 'band v-up', 'dynamic chest stretch', 'dumbbell burpee', 'exercise ball alternating arm ups', 'exercise ball back extension with arms extended', 'exercise ball back extension with hands behind head', 'exercise ball back extension with knees off ground', 'exercise ball back extension with rotation', 'exercise ball hug', 'exercise ball lat stretch', 'exercise ball lower back stretch', 'exercise ball lying side lat stretch', 'exercise ball prone leg raise', 'exercise ball prone lower body rotation', 'exercise ball one legged diagonal kick hamstring curl', 'exercise ball pike push up', 'forward jump', 'backward jump', 'kneeling jump squat', 'pelvic tilt into bridge', 'reverse hyper on flat bench', 'seated glute stretch', 'twist hip lift', 'push-up on lower arms', 'crab twist toe touch', 'forward jump', 'backward jump', 'one leg squat', 'sissy squat', 'standing calf raise', 'butterfly yoga pose', 'oblique crunch v. 2', 'sledge hammer', 'hamstring stretch', 'all fours squad stretch', 'chair leg extended stretch', 'exercise ball hip flexor stretch', 'exercise ball seated hamstring stretch', 'intermediate hip flexor and quad stretch', 'leg up hamstring stretch', 'reclining big toe pose with rope', 'runners stretch', 'seated wide angle pose sequence', 'standing hamstring and calf stretch with strap', 'world greatest stretch', 'squat to overhead reach', 'squat to overhead reach with twist', 'posterior step to overhead reach', 'lunge with twist', 'push and pull bodyweight', 'dumbbell push press', 'medicine ball close grip push up', 'squat on bosu ball', 'prone twist on stability ball', 'assisted lying calves stretch', 'assisted lying glutes stretch', 'assisted lying gluteus and piriformis stretch', 'assisted side lying adductor stretch', 'assisted prone lying quads stretch', 'assisted prone rectus femoris stretch', 'assisted seated pectoralis major stretch with stability ball',
            ],
            'YOGA' => [
                'yoga', 'pose', 'asana', 'vinyasa', 'flow', 'warrior', 'triangle', 'cobra', 'downward dog', 'meditation',
            ],
            'PILATES' => [
                'pilates', 'hundred', 'roll up', 'leg circle', 'teaser', 'swan dive', 'mat',
            ],
            'NATATION' => [
                'swim', 'stroke', 'freestyle', 'butterfly', 'backstroke', 'breaststroke', 'crawl', 'pool', 'water',
            ],
            'HIIT' => [
                'hiit', 'circuit', 'plyometrics', 'thruster', 'kettlebell swing', 'tabata', 'crossfit',
            ],
            'ZUMBA' => [
                'zumba', 'dance fitness', 'salsa', 'merengue', 'reggaeton', 'dance',
            ],
        ];
    }

    private function inferExerciseType(string $exerciseName, array $typeKeywords): string
    {
        $lowerName = strtolower($exerciseName);
        foreach ($typeKeywords as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($lowerName, $keyword)) {
                    return $type;
                }
            }
        }
        return 'MUSCULATION'; // Default type if no keywords are found
    }
}