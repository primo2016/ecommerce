
export interface CategoryResponse {
    id: number;
    name: string;
    description: string;
    discountAssigned?: number;
}

export interface ProductResponse {
    id: number;
    name: string;
    description: string;
    amount: number;
    discountToApply: number;
    categories?: CategoryResponse[];
}

export interface CalculatorResponse {
    subtotal: number;
    total: number;
    totalDiscountApplied: number;
    totalAdditionalDiscountApplied: number;
}
