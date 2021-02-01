import BounceLoader from "react-spinners/BounceLoader";
import { css } from "@emotion/core";

const override = css`
display: block;
margin: 0 auto;
border-color: red;
`;

export default function Loader(props) {
    return (
        <>
            {props.loading &&
                <div className="loader">
                    <BounceLoader color='rgb(54, 215, 183)' loading={props.loading} css={override} size={150} />
                </div>
            }
        </>
    );
}