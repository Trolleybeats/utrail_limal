<?php

namespace App\Console\Commands;

use App\Mail\RappelVersement;
use App\Models\Versement;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelsVersements extends Command
{
    /**
     * Nombre de jours avant l'échéance pour envoyer le rappel.
     */
    const JOURS_AVANT = 3;

    protected $signature = 'versements:envoyer-rappels
                            {--jours=3 : Nombre de jours avant l\'échéance pour envoyer le rappel}
                            {--dry-run : Affiche les versements sans envoyer d\'e-mail}';

    protected $description = 'Envoie un rappel par e-mail pour les versements en attente dont l\'échéance approche';

    public function handle(): int
    {
        $jours = (int) $this->option('jours');
        $dryRun = $this->option('dry-run');

        $today = Carbon::today();
        $limite = $today->copy()->addDays($jours);

        $versements = Versement::with(['membre.participant'])
            ->where('statut', 'pending')
            ->whereBetween('date_echeance', [$today, $limite])
            ->get();

        if ($versements->isEmpty()) {
            $this->info('Aucun versement en attente trouvé pour les ' . $jours . ' prochains jours.');
            return self::SUCCESS;
        }

        $this->info("Versements trouvés : {$versements->count()}");

        $envoyes = 0;
        $erreurs = 0;

        foreach ($versements as $versement) {
            $participant = $versement->membre?->participant;

            if (! $participant || ! $participant->email) {
                $this->warn("Versement #{$versement->id} — participant ou e-mail introuvable, ignoré.");
                $erreurs++;
                continue;
            }

            if ($dryRun) {
                $this->line(sprintf(
                    '[DRY-RUN] Rappel pour %s %s <%s> — versement n°%d, échéance %s, montant %.2f €',
                    $participant->prenom,
                    $participant->nom,
                    $participant->email,
                    $versement->numero_versement,
                    Carbon::parse($versement->date_echeance)->format('d/m/Y'),
                    $versement->montant / 100,
                ));
                $envoyes++;
                continue;
            }

            try {
                Mail::to($participant->email)->send(new RappelVersement($versement));
                $this->line("E-mail envoyé à {$participant->email} pour le versement #{$versement->id}.");
                $envoyes++;
            } catch (\Throwable $e) {
                $this->error("Échec pour versement #{$versement->id} : {$e->getMessage()}");
                $erreurs++;
            }
        }

        $this->info("{$envoyes} rappel(s) envoyé(s), {$erreurs} erreur(s).");

        return $erreurs > 0 ? self::FAILURE : self::SUCCESS;
    }
}
