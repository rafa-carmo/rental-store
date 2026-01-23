import { Head, Link } from '@inertiajs/react';
import { Form } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { index, update } from '@/actions/App/Http/Controllers/ItemController';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';
import { Textarea } from '@/components/ui/textarea';

type ItemType = {
    id: number;
    name: string;
    description: string | null;
    is_active: boolean;
};

type Item = {
    id: number;
    name: string;
    description: string | null;
    image: string | null;
    item_type_id: number;
    status: 'disponivel' | 'alugado' | 'indisponivel';
    created_at: string;
    updated_at: string;
    item_type: ItemType;
};

type Props = {
    item: Item;
    itemTypes: ItemType[];
};

export default function Edit({ item, itemTypes }: Props) {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: dashboard().url,
        },
        {
            title: 'Itens',
            href: index().url,
        },
        {
            title: item.name,
            href: '#',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar - ${item.name}`} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card className="mx-auto w-full max-w-2xl">
                    <CardHeader>
                        <div className="flex items-center gap-4">
                            <Button variant="ghost" size="icon" asChild>
                                <Link href={index().url}>
                                    <ArrowLeft className="h-4 w-4" />
                                </Link>
                            </Button>
                            <div>
                                <CardTitle>Editar Item</CardTitle>
                                <CardDescription>
                                    Atualize as informações do item
                                </CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Form {...update.form(item.id)}>
                            {({ errors, processing }) => (
                                <div className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="name">Nome *</Label>
                                        <Input
                                            id="name"
                                            name="name"
                                            defaultValue={item.name}
                                            placeholder="Digite o nome do item"
                                            required
                                        />
                                        {errors.name && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.name}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="description">Descrição</Label>
                                        <Textarea
                                            id="description"
                                            name="description"
                                            defaultValue={item.description || ''}
                                            placeholder="Digite uma descrição (opcional)"
                                            rows={4}
                                        />
                                        {errors.description && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.description}
                                            </p>
                                        )}
                                    </div>

                                    {item.image && (
                                        <div className="space-y-2">
                                            <Label>Imagem Atual</Label>
                                            <div className="relative h-40 w-full overflow-hidden rounded-lg border">
                                                <img
                                                    src={`/storage/${item.image}`}
                                                    alt={item.name}
                                                    className="h-full w-full object-cover"
                                                />
                                            </div>
                                        </div>
                                    )}

                                    <div className="space-y-2">
                                        <Label htmlFor="image">
                                            {item.image ? 'Nova Imagem' : 'Imagem'}
                                        </Label>
                                        <Input
                                            id="image"
                                            name="image"
                                            type="file"
                                            accept="image/*"
                                        />
                                        <p className="text-sm text-muted-foreground">
                                            Tamanho máximo: 2MB
                                        </p>
                                        {errors.image && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.image}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="item_type_id">Tipo de Item *</Label>
                                        <Select
                                            name="item_type_id"
                                            defaultValue={item.item_type_id.toString()}
                                            required
                                        >
                                            <SelectTrigger>
                                                <SelectValue placeholder="Selecione o tipo" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {itemTypes.map((type) => (
                                                    <SelectItem
                                                        key={type.id}
                                                        value={type.id.toString()}
                                                    >
                                                        {type.name}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.item_type_id && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.item_type_id}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="status">Status *</Label>
                                        <Select
                                            name="status"
                                            defaultValue={item.status}
                                            required
                                        >
                                            <SelectTrigger>
                                                <SelectValue />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="disponivel">
                                                    Disponível
                                                </SelectItem>
                                                <SelectItem value="alugado">Alugado</SelectItem>
                                                <SelectItem value="indisponivel">
                                                    Indisponível
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                        {errors.status && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.status}
                                            </p>
                                        )}
                                    </div>

                                    <div className="flex justify-end gap-4">
                                        <Button variant="outline" asChild>
                                            <Link href={index().url}>Cancelar</Link>
                                        </Button>
                                        <Button type="submit" disabled={processing}>
                                            {processing ? 'Salvando...' : 'Atualizar'}
                                        </Button>
                                    </div>
                                </div>
                            )}
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
