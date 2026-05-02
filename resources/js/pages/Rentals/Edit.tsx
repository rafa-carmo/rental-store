import { Form, Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { index, update } from '@/actions/App/Http/Controllers/RentalController';
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

type Customer = {
    id: number;
    name: string;
};

type Item = {
    id: number;
    name: string;
};

type Rental = {
    id: number;
    customer_id: number;
    item_id: number;
    value: string;
    pickup_date: string;
    return_date: string;
    customer: Customer;
    item: Item;
};

type Props = {
    rental: Rental;
    customers: Customer[];
    items: Item[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Aluguéis',
        href: index().url,
    },
    {
        title: 'Editar Aluguel',
        href: '#',
    },
];

export default function Edit({ rental, customers, items }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Aluguel" />
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
                                <CardTitle>Editar Aluguel</CardTitle>
                                <CardDescription>
                                    Atualize as informações do aluguel
                                </CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Form {...update.form(rental.id)} defaults={rental}>
                            {({ errors, processing, data, setData }) => (
                                <div className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="customer_id">
                                            Cliente *
                                        </Label>
                                        <Select
                                            name="customer_id"
                                            value={
                                                data.customer_id?.toString() ||
                                                rental.customer_id.toString()
                                            }
                                            onValueChange={(value) =>
                                                setData(
                                                    'customer_id',
                                                    parseInt(value),
                                                )
                                            }
                                            required
                                        >
                                            <SelectTrigger>
                                                <SelectValue placeholder="Selecione um cliente" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {customers.map((customer) => (
                                                    <SelectItem
                                                        key={customer.id}
                                                        value={customer.id.toString()}
                                                    >
                                                        {customer.name}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.customer_id && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.customer_id}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="item_id">Item *</Label>
                                        <Select
                                            name="item_id"
                                            value={
                                                data.item_id?.toString() ||
                                                rental.item_id.toString()
                                            }
                                            onValueChange={(value) =>
                                                setData(
                                                    'item_id',
                                                    parseInt(value),
                                                )
                                            }
                                            required
                                        >
                                            <SelectTrigger>
                                                <SelectValue placeholder="Selecione um item" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {items.map((item) => (
                                                    <SelectItem
                                                        key={item.id}
                                                        value={item.id.toString()}
                                                    >
                                                        {item.name}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.item_id && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.item_id}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="value">Valor *</Label>
                                        <Input
                                            id="value"
                                            name="value"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            defaultValue={rental.value}
                                            required
                                        />
                                        {errors.value && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.value}
                                            </p>
                                        )}
                                    </div>

                                    <div className="grid gap-4 md:grid-cols-2">
                                        <div className="space-y-2">
                                            <Label htmlFor="pickup_date">
                                                Data de Retirada *
                                            </Label>
                                            <Input
                                                id="pickup_date"
                                                name="pickup_date"
                                                type="date"
                                                defaultValue={
                                                    rental.pickup_date
                                                }
                                                required
                                            />
                                            {errors.pickup_date && (
                                                <p className="text-sm text-red-600 dark:text-red-400">
                                                    {errors.pickup_date}
                                                </p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="return_date">
                                                Data de Entrega *
                                            </Label>
                                            <Input
                                                id="return_date"
                                                name="return_date"
                                                type="date"
                                                defaultValue={
                                                    rental.return_date
                                                }
                                                required
                                            />
                                            {errors.return_date && (
                                                <p className="text-sm text-red-600 dark:text-red-400">
                                                    {errors.return_date}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    <div className="flex justify-end gap-4">
                                        <Button variant="outline" asChild>
                                            <Link href={index().url}>
                                                Cancelar
                                            </Link>
                                        </Button>
                                        <Button
                                            type="submit"
                                            disabled={processing}
                                        >
                                            {processing
                                                ? 'Salvando...'
                                                : 'Salvar'}
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
