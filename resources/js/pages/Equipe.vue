<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';

const props = defineProps({
    equipes: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/equipe.jpg"
                alt="Équipe U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>
    <main>
        <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Notre équipe
            </h2>

            <h3
                class="mb-4 text-xl font-semibold text-gray-800 sm:text-2xl md:mb-6 md:text-3xl lg:text-[32px]"
            >
                Vous rêvez de prendre le départ d’un trail ou d’un ultra-trail ?
            </h3>
            <p
                class="mb-6 text-lg text-gray-700 sm:text-xl md:mb-8 md:text-2xl lg:text-[24px]"
            >
                Avec U-Trail Limal, nous vous accompagnons sur plusieurs mois
                pour transformer ce rêve en réalité, grâce à un programme
                complet mêlant préparation physique et préparation spécifique au
                trail, au sein d’un projet collectif motivant.
            </p>
        </section>
        <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
            >
                <Card
                    v-for="equipe in equipes"
                    :key="equipe.id"
                    class="overflow-hidden p-0"
                >
                    <img
                        v-if="equipe.photo"
                        :src="`/storage/${equipe.photo}`"
                        :alt="`${equipe.prenom} ${equipe.nom}`"
                        class="h-60 w-full object-cover"
                    />
                    <div v-else class="h-60 w-full bg-muted" />
                    <CardHeader>
                        <CardTitle
                            >{{ equipe.prenom }} {{ equipe.nom }}</CardTitle
                        >
                        <CardDescription>{{ equipe.role }}</CardDescription>
                    </CardHeader>
                    <CardContent v-if="equipe.description">
                        <p class="pt-5 text-sm text-gray-600">
                            <a
                                :href="`#membre-${equipe.id}`"
                                class="text-primary hover:underline"
                            >
                                Découvrir le profil →
                            </a>
                        </p>
                    </CardContent>
                </Card>
            </div>
        </section>
        <section
            v-for="equipe in equipes"
            :key="equipe.id"
            :id="`membre-${equipe.id}`"
            class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14"
        >
            <h3
                class="mb-4 text-xl font-semibold text-gray-800 sm:text-2xl md:mb-6 md:text-3xl lg:text-[32px]"
            >
                {{ equipe.prenom }} {{ equipe.nom }} - {{ equipe.role }}
            </h3>
            <p
                v-for="(description, index) in equipe.description
                    .split('\n')
                    .filter((p) => p.trim())"
                :key="index"
                class="mb-6 text-lg text-gray-700 sm:text-xl md:mb-8 md:text-2xl lg:text-[24px]"
            >
                {{ description }}
            </p>
        </section>
    </main>
    <Footer />
</template>
