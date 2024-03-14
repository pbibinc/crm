import AppointedLeadQuestionare from "./views/appoinnted-lead-questionare.jsx";
import GeneralLiabilitiesForm from "./product-form/general-liabilites-form.jsx";
import ContextDataProvider from "./contexts/context-data-provider.jsx";
import GeneralLiabilitiesFormEdit from "./views/general-liabilities-edit.jsx";
import workersCompensationFormEdit from "./views/workers-compensation-edit.jsx";
import Header from "./partials-form/header.jsx";
import WorkersCompensationFormEdit from "./views/workers-compensation-edit.jsx";

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
        path: "/workers-compensation-form/edit",
        element: (
            <ContextDataProvider>
                <WorkersCompensationFormEdit />
            </ContextDataProvider>
        ),
    },
    {
        path: "*",
        element: <div>404</div>,
    },
]);

export default router;
