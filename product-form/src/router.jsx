import { createBrowserRouter } from "react-router-dom";
import AppointedLeadQuestionare from "./views/appoinnted-lead-questionare.jsx";
import GeneralLiabilitiesForm from "./product-form/general-liabilites-form.jsx";
import ContextDataProvider from "./contexts/context-data-provider.jsx";
import GeneralLiabilitiesFormEdit from "./views/general-liabilities-edit.jsx";

const router = createBrowserRouter([
    {
        path: "/appoinnted-lead-questionare",
        element: <AppointedLeadQuestionare />,
    },
    {
        path: "/general-liabilities-form",
        element: (
            <ContextDataProvider>
                <GeneralLiabilitiesForm />
            </ContextDataProvider>
        ),
    },
    {
        path: "/general-liabilities-form/edit",
        element: (
            <ContextDataProvider>
                <GeneralLiabilitiesFormEdit />
            </ContextDataProvider>
        ),
    },
    {
        path: "*",
        element: <div>404</div>,
    },
]);

export default router;
