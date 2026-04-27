<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    prenom: '',
    nom: '',
    email: '',
    telephone: '',
    rgpd: false,
    pre_inscription: false,
});

const submit = () => {
    form.post('/inscription', {
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            console.error('Validation errors:', form.errors);
        },
    });
};
</script>

<template>
    <Head>
        <title>Inscription au projet</title>
        <meta
            name="description"
            content="Inscrivez-vous à la séance d'information du projet annuel de U-Trail Limal. Découvrez le programme, les modalités d'inscription et participez à notre aventure trail en Brabant wallon."
        />
        <meta
            name="keywords"
            content="inscription projet trail, séance d'information trail, participation projet trail, programme trail, U-Trail Limal, trail Brabant wallon"
        />
        <meta property="og:title" content="Inscription au projet" />
        <meta
            property="og:description"
            content="Inscrivez-vous à la séance d'information du projet annuel de U-Trail Limal. Découvrez le programme et participez à notre aventure trail en Brabant wallon."
        />
        <meta property="og:url" content="https://utrail-limal.be/inscription" />
    </Head>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav />
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/inscription.jpg"
                alt="Inscription U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
        <div class="absolute inset-0 bg-[#d9d9d9] opacity-10"></div>
    </header>

    <main id="main-content" class="bg-[#f6f6f6]">
        <section class="mx-auto w-full max-w-[1182px] px-4 py-10 md:py-16">
            <!-- Page title -->
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Inscription au projet
            </h2>

            <!-- Step intro -->
            <div class="mb-8 w-full">
                <h3 class="mb-4 font-semibold text-black md:text-[24px]">
                    Étape 1 — Séance d'information
                </h3>
                <p class="text-[16px] leading-[22px] text-black md:text-[18px]">
                    Vous commencez par vous inscrire à une séance d'information.
                    Celle-ci vous permettra de découvrir l'ensemble du projet :
                    le programme d'entraînements, l'organisation, ainsi que les
                    modalités de paiement.
                </p>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <!-- Message de réussite -->
                <p
                    v-if="form.recentlySuccessful"
                    role="status"
                    aria-live="polite"
                    class="text-sm text-[#28a745]"
                >
                    Votre inscription a été encodée avec succès ! Rendez-vous à
                    la séance d'information pour découvrir le projet en détail.
                </p>

                <!-- Prénom -->
                <div class="flex flex-col gap-2">
                    <label
                        for="prenom"
                        class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                    >
                        Prénom&nbsp;<span class="text-[#c42827]">*</span>
                    </label>
                    <input
                        v-model="form.prenom"
                        type="text"
                        id="prenom"
                        name="prenom"
                        required
                        :aria-invalid="!!form.errors.prenom"
                        :aria-describedby="
                            form.errors.prenom ? 'prenom-error' : undefined
                        "
                        class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                    />
                    <p
                        v-if="form.errors.prenom"
                        id="prenom-error"
                        role="alert"
                        class="text-sm text-[#c42827]"
                    >
                        {{ form.errors.prenom }}
                    </p>
                </div>

                <!-- Nom de famille -->
                <div class="flex flex-col gap-2">
                    <label
                        for="nom"
                        class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                    >
                        Nom&nbsp;<span class="text-[#c42827]">*</span>
                    </label>
                    <input
                        v-model="form.nom"
                        type="text"
                        id="nom"
                        name="nom"
                        required
                        :aria-invalid="!!form.errors.nom"
                        :aria-describedby="
                            form.errors.nom ? 'nom-error' : undefined
                        "
                        class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                    />
                    <p
                        v-if="form.errors.nom"
                        id="nom-error"
                        role="alert"
                        class="text-sm text-[#c42827]"
                    >
                        {{ form.errors.nom }}
                    </p>
                </div>

                <!-- Adresse mail -->
                <div class="flex flex-col gap-2">
                    <label
                        for="email"
                        class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                    >
                        Adresse mail&nbsp;<span class="text-[#c42827]">*</span>
                    </label>
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        name="email"
                        required
                        :aria-invalid="!!form.errors.email"
                        :aria-describedby="
                            form.errors.email ? 'email-error' : undefined
                        "
                        class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                    />
                    <p
                        v-if="form.errors.email"
                        id="email-error"
                        role="alert"
                        class="text-sm text-[#c42827]"
                    >
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- N° de téléphone -->
                <div class="flex flex-col gap-2">
                    <label
                        for="telephone"
                        class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                    >
                        N° de téléphone&nbsp;<span class="text-[#c42827]"
                            >*</span
                        >
                    </label>
                    <input
                        v-model="form.telephone"
                        type="tel"
                        id="telephone"
                        name="telephone"
                        required
                        :aria-invalid="!!form.errors.telephone"
                        :aria-describedby="
                            form.errors.telephone
                                ? 'telephone-error'
                                : undefined
                        "
                        class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                    />
                    <p
                        v-if="form.errors.telephone"
                        id="telephone-error"
                        role="alert"
                        class="text-sm text-[#c42827]"
                    >
                        {{ form.errors.telephone }}
                    </p>
                </div>

                <!-- RGPD consentement -->
                <div class="flex items-start gap-3">
                    <input
                        v-model="form.rgpd"
                        type="checkbox"
                        id="rgpd"
                        name="rgpd"
                        required
                        class="mt-1 h-[25px] w-[25px] shrink-0 accent-[#c42827]"
                    />
                    <label
                        for="rgpd"
                        class="text-[16px] leading-[22px] text-black md:text-[18px]"
                    >
                        En cochant cette case, j'accepte que mes données
                        personnelles renseignées lors de cette inscription
                        soient transmises à U-trail Limal pour la gestion de ma
                        participation. J'ai lu et j'accepte la politique de
                        confidentialité.&nbsp;<span class="text-[#c42827]"
                            >*</span
                        >
                    </label>
                </div>

                <!-- Pre-inscription acknowledgment -->
                <div class="flex items-start gap-3">
                    <input
                        v-model="form.pre_inscription"
                        type="checkbox"
                        id="pre_inscription"
                        name="pre_inscription"
                        required
                        class="mt-1 h-[25px] w-[25px] shrink-0 accent-[#c42827]"
                    />
                    <label
                        for="pre_inscription"
                        class="text-[16px] leading-[22px] text-black md:text-[18px]"
                    >
                        En cochant cette case, je comprends que cette
                        inscription ne vaut pas pour inscription définitive au
                        projet. La présente inscription donne accès à la séance
                        d'informations de début de projet ayant lieu en
                        décembre.&nbsp;<span class="text-[#c42827]">*</span>
                    </label>
                </div>

                <!-- Submit button -->
                <div class="flex justify-center pt-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="cursor-pointer rounded-[2px] bg-[#c42827] px-[44px] py-[18px] text-[20px] leading-[22px] font-semibold text-white hover:bg-[#a82120] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white disabled:cursor-not-allowed disabled:opacity-50 md:text-[24px]"
                    >
                        S'inscrire
                    </button>
                </div>
            </form>
        </section>
    </main>

    <Footer />
</template>
