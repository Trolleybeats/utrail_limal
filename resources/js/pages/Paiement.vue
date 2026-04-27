<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import CourseSection from '@/components/site/CourseSection.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    participant: {
        type: Object,
        required: true,
    },
    tarifs: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    date_naissance: '',
    participation_un: '',
    distance_un: '',
    logement_un: '',
    participation_deux: '',
    distance_deux: '',
    logement_deux: '',
    tshirt_taille: '',
    rgpd: false,
    inscription: false,
});

const montantTotal = computed(() => {
    let total = 0;

    if (
        form.participation_un === 1 &&
        form.distance_un &&
        form.distance_un !== 'non'
    ) {
        total += Number(props.tarifs.course_un[form.distance_un] ?? 0);
    }
    if (form.logement_un === 1) {
        total += Number(props.tarifs.logement_un?.prix ?? 0);
    }
    if (
        form.participation_deux === 1 &&
        form.distance_deux &&
        form.distance_deux !== 'non'
    ) {
        total += Number(props.tarifs.course_deux[form.distance_deux] ?? 0);
    }
    if (form.logement_deux === 1) {
        total += Number(props.tarifs.logement_deux?.prix ?? 0);
    }
    total += Number(props.tarifs.tshirt ?? 0);

    return total;
});

const submit = () => {
    form.post(`/paiement/${props.participant.token}`, {
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            alert(
                "Une erreur est survenue lors de l'envoi de votre inscription. Veuillez réessayer.",
            );
        },
    });
};
</script>

<template>
    <Head>
        <title>Paiement de l'inscription</title>
        <meta
            name="description"
            content="Finalisez votre inscription au projet annuel de U-Trail Limal en procédant au paiement. Découvrez les modalités de paiement et confirmez votre participation à notre aventure trail en Brabant wallon."
        />
        <meta
            name="keywords"
            content="paiement inscription trail, finaliser inscription trail, modalités paiement trail, confirmation inscription trail, U-Trail Limal, trail Brabant wallon"
        />
        <meta property="og:title" content="Paiement de l'inscription" />
        <meta
            property="og:description"
            content="Finalisez votre inscription au projet annuel de U-Trail Limal en procédant au paiement. Découvrez les modalités de paiement et confirmez votre participation à notre aventure trail en Brabant wallon."
        />
        <meta property="og:url" content="https://utrail-limal.be/paiement" />
    </Head>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/paiement.jpg"
                alt="Paiement U-Trail Limal"
                class="h-full w-full object-cover object-[center_60%]"
            />
        </figure>
    </header>
    <main id="main-content">
        <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Inscription au projet
            </h2>
        </section>
        <form
            @submit.prevent="submit"
            class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14"
        >
            <!-- Participant info -->
            <div class="mb-8 rounded-[6px] bg-white px-6 py-4">
                <p
                    class="text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Inscription pour :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ participant.prenom }} {{ participant.nom }}
                    </span>
                </p>
                <p class="mt-1 text-[15px] text-[#586166]">
                    {{ participant.email }}
                </p>
            </div>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="date_naissance"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Date de naissance&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <input
                    v-model="form.date_naissance"
                    type="date"
                    id="date_naissance"
                    name="date_naissance"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                />
                <p
                    v-if="form.errors.date_naissance"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.date_naissance }}
                </p>
            </div>

            <!-- Course n°1 -->
            <CourseSection
                title="Course n°1"
                field-prefix="un"
                :tarifs-distance="tarifs.course_un"
                :tarifs-logement="tarifs.logement_un"
                :errors="form.errors"
                v-model:participation="form.participation_un"
                v-model:distance="form.distance_un"
                v-model:logement="form.logement_un"
            />

            <!-- Course n°2 -->
            <CourseSection
                title="Course n°2"
                field-prefix="deux"
                :tarifs-distance="tarifs.course_deux"
                :tarifs-logement="tarifs.logement_deux"
                :errors="form.errors"
                v-model:participation="form.participation_deux"
                v-model:distance="form.distance_deux"
                v-model:logement="form.logement_deux"
            />

            <!-- T-shirt -->
            <h3 class="mb-4 text-xl font-semibold md:mb-6 md:text-[36px]">
                T-shirt
            </h3>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="tshirt_taille"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Taille&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <select
                    v-model="form.tshirt_taille"
                    id="tshirt_taille"
                    name="tshirt_taille"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option value="xs">XS</option>
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                    <option value="xl">XL</option>
                    <option value="xxl">XXL</option>
                </select>
                <p
                    v-if="form.errors.tshirt_taille"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.tshirt_taille }}
                </p>
            </div>

            <!-- RGPD -->
            <div class="mb-6 flex items-start gap-2">
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
                    personnelles renseignées lors de cette inscription soient
                    transmises à U-trail Limal pour la gestion de ma
                    participation. J'ai lu et j'accepte la politique de
                    confidentialité.&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <p v-if="form.errors.rgpd" class="text-sm text-[#c42827]">
                    {{ form.errors.rgpd }}
                </p>
            </div>

            <!-- Inscription -->
            <div class="mb-6 flex items-start gap-2">
                <input
                    v-model="form.inscription"
                    type="checkbox"
                    id="inscription"
                    name="inscription"
                    required
                    class="mt-1 h-[25px] w-[25px] shrink-0 accent-[#c42827]"
                />
                <label
                    for="inscription"
                    class="text-[16px] leading-[22px] text-black md:text-[18px]"
                >
                    En cochant cette case, je comprends que cette inscription
                    vaut pour inscription définitive au projet. La présente
                    inscription donne accès à l’ensemble du programme
                    d’entrainement ainsi qu’aux courses liées au projet.
                    &nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <p
                    v-if="form.errors.inscription"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.inscription }}
                </p>
            </div>

            <!-- Calcul du prix -->
            <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
                <h2
                    class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
                >
                    Récapitulatif
                </h2>
                <p
                    class="mb-4 text-center text-[18px] text-[#586166] md:text-[20px]"
                >
                    Montant total :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ montantTotal.toFixed(2) }} €
                    </span>
                </p>
            </section>

            <!-- Submit button -->
            <div class="flex justify-center pt-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="cursor-pointer rounded-[2px] bg-[#c42827] px-[44px] py-[18px] text-[20px] leading-[22px] font-semibold text-white hover:bg-[#a82120] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white disabled:cursor-not-allowed disabled:opacity-50 md:text-[24px]"
                >
                    Payer
                </button>
            </div>
        </form>
    </main>
    <Footer />
</template>
