Plug the below code into the live editor of mermaid js. This link should also show the complete graph
https://mermaid.live/view#pako:eNqFU11vmzAU_SuWX_KCM74CKQ_TqnSaKlVTlUl9KOzBxS5YATsypmsW5b_PGJwCRRoPxj733Hvsc-0zzAWhMIGvlfiTl1gq8LDPONDfPSf0PTUjeMQF_d3DO81Ju2FY3-GmfBFYkvQ6-9KU4jiEH0TBeGrGAdnTgjWKyrSfSKyY4FZhJI3QTwFyIQ6MIvTVVJhEb3PF3ugH4ypvq5gUhHYVyw9gJQfZlabaLSzxzGoFrOSupPlhxDPrb2fQlPhIE0AYrgUnDqjwC60SkEHDAn0aBJd5KkJPuGLEio53PSfe87cJdbBgZjtCGhetmno0Ct8SApR2UrdMc7rOfTQSoUd8WkCXSvaRwaUfoqt5VVkt-W9d_q9lljh3zeJX1f1CD0cNmkDWaDm6ZZ_9nqVYy2dJ0_vyaVv9r6SSdqZU5gJZ76ADayprzIh-ZOeuQAZVSWuawe7oBEt94IxfNA-3Svw68RwmSrbUge2RYEXvGC4krqfgd8KUkBY7Yg6TM3yHCYq27nrjxW7s33hBEG0CB55gEofr2A1uIj-MN74bbcKLA_8KoYv6ay8MI9_T5K0bBr6nE6RoixImr7hq-uLPhtppXf4BDJxexQ

```mermaidjs
flowchart LR
    Index[Index Page]
    Cart[Cart]
    Dashboard[Dashboard/shop]
    Login[Login]
    Register[Registration Page]

    Index--No cookie-->Login
    Index--Active cookie-->Dashboard

    Login--Click 'register'-->Register
    Login--Click 'Login' -->LoginCheck
    LoginCheck@{ shape: diamond, label: "Login Check" }
    LoginCheck--Valid Login-->Dashboard
    LoginCheck--Invalid Login-->Login

    Dashboard--Logout-->Login
    Dashboard--Add to cart-->Cart
    Cart--Pay-->Cart
    Cart--Logout-->Login
    Cart--Click 'Go to Dashboard'-->Dashboard

    RegisterCheck@{ shape: diamond, label: "Register Check" }
    Register--Click 'Register'-->RegisterCheck
    RegisterCheck--Valid registration-->Dashboard
    RegisterCheck--Invalid registration-->Register
    Register--Click 'Click here to login'-->Login
```