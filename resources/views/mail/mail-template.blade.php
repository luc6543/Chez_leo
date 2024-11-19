<style>
	* {
		font-family: 'Arial', sans-serif;
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}
	.header {
		width: 100%;
		background-color: #0f172b;
		color: white;
	}
	.title {
		text-align: center;
		font-size: 2rem;
		margin-top: 0;
	}
	.img {
		width: 10%;
		display: flex;
		/* justify-content: center; */
		margin-left: 45%;
	}
	.footer {
		background-color: #0f172b;
		color: white;
		display: flex;
		justify-content: center;
		gap: 1rem;
		flex-direction: column;
		padding-left: 15%;
	}
	ul,
	li {
		list-style: none;
	}
    .content{
        padding: 2rem;
        margin-bottom: 12.25rem;
    }
    .footer p{
        padding-top: 2rem;
    }
</style>
<div>
	<!-- {{-- header --}} -->
	<div class="header">
		<img
			class="img"
			src="https://cdn.discordapp.com/attachments/1306166047271030814/1308041469910843432/chezleo.png?ex=673c800c&is=673b2e8c&hm=41ffd4a1abb0bc17ac17b2a6f5544a6fe4d6af7eb885162b5efc29fc6bebf19b&"
			alt=""
		/>
	</div>
	<!-- content -->
	<div class="content">
        <h1>{{$title}}</h1>
		<p>
            {!! $content !!}
        </p>
	</div>
	<!-- footer -->
	<div class="footer">
		<p>contact</p>
		<ul>
			<li>EenStraat 109, 3651 EenPlek, Nederland</li>
			<li>+31 06 345 67890</li>
			<li>info@chezleo.nl</li>
		</ul>
		<p>Copyright 2023 Chez Leo</p>
	</div>
</div>
